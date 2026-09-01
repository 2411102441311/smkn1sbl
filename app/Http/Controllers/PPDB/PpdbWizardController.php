<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PPDB\Registration;
use App\Services\OcrService;
use App\Services\SawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Wizard pendaftaran PPDB, 7 langkah sesuai alur:
 * 1. Biodata -> 2. Data Ortu -> 3. Dokumen -> 4. Foto Rapor -> (OCR otomatis)
 * -> 5. Konfirmasi Nilai -> (SAW otomatis) -> 6. Rekomendasi -> 7. Pilih Jurusan -> Submit Final
 *
 * Semua data disimpan sementara di SESSION selama proses wizard berlangsung.
 * Baru benar-benar disimpan ke database (dan nomor pendaftaran digenerate)
 * di langkah paling akhir (submitFinal).
 */
class PpdbWizardController extends Controller
{
    protected string $sessionKey = 'ppdb_wizard';

    protected function wizardData(): array
    {
        return session($this->sessionKey, []);
    }

    protected function putWizardData(array $data): void
    {
        session([$this->sessionKey => array_merge($this->wizardData(), $data)]);
    }

    // ============ LANGKAH 1: BIODATA ============
    public function biodataForm()
    {
        return view('ppdb.wizard.step1-biodata', ['old' => $this->wizardData()['biodata'] ?? []]);
    }

    public function biodataStore(Request $request)
    {
        $data = $request->validate([
            'nik' => 'nullable|string|max:20',
            'family_card_number' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'height_cm' => 'nullable|numeric|min:0|max:250',
            'weight_kg' => 'nullable|numeric|min:0|max:300',
            'religion' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'school_origin' => 'nullable|string|max:255',
            'has_kip' => 'nullable|boolean',
            'kip_number' => 'nullable|required_if:has_kip,1|string|max:30',
        ]);
 
        $data['has_kip'] = $request->boolean('has_kip');
 
        $this->putWizardData(['biodata' => $data]);
 
        return redirect()->route('ppdb.wizard.parents');
    }

    // ============ LANGKAH 2: DATA ORANG TUA ============
    public function parentsForm()
    {
        if (empty($this->wizardData()['biodata'])) {
            return redirect()->route('ppdb.wizard.biodata')->with('error', 'Lengkapi biodata terlebih dahulu.');
        }

        return view('ppdb.wizard.step2-parents', ['old' => $this->wizardData()['parents'] ?? []]);
    }

    public function parentsStore(Request $request)
    {
        $data = $request->validate([
            'father_name' => 'nullable|string|max:255',
            'father_nik' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:30',
            'father_occupation' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:255',
            'mother_nik' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:30',
            'mother_occupation' => 'nullable|string|max:100',
        ]);
 
        $this->putWizardData(['parents' => $data]);
 
        return redirect()->route('ppdb.wizard.documents');
    }

    // ============ LANGKAH 3: UPLOAD DOKUMEN ============
    public function documentsForm()
    {
        if (empty($this->wizardData()['parents'])) {
            return redirect()->route('ppdb.wizard.parents')->with('error', 'Lengkapi data orang tua terlebih dahulu.');
        }

        return view('ppdb.wizard.step3-documents', ['uploaded' => $this->wizardData()['documents'] ?? []]);
    }

    public function documentsStore(Request $request)
    {
        $request->validate([
            'doc_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_akte' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $documentLabels = [
            'doc_kk' => 'Kartu Keluarga',
            'doc_akte' => 'Akte Kelahiran',
            'doc_ijazah' => 'Ijazah / Surat Keterangan Lulus',
            'doc_foto' => 'Pas Foto',
        ];

        $uploaded = $this->wizardData()['documents'] ?? [];
        $wizardToken = $this->wizardData()['token'] ?? ($this->wizardData()['token'] = (string) Str::uuid());

        foreach ($documentLabels as $field => $label) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->storeAs(
                    "ppdb/temp/{$wizardToken}",
                    $field . '_' . time() . '.' . $file->getClientOriginalExtension(),
                    'public'
                );

                $uploaded[$field] = [
                    'label' => $label,
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $this->putWizardData(['documents' => $uploaded, 'token' => $wizardToken]);

        return redirect()->route('ppdb.wizard.reportCard');
    }

    // ============ LANGKAH 4: UPLOAD FOTO RAPOR (lalu OCR otomatis) ============
    public function reportCardForm()
    {
        return view('ppdb.wizard.step4-report-card');
    }

    public function reportCardStore(Request $request, OcrService $ocrService)
    {
        $request->validate([
            'report_cards' => 'required|array|min:1',
            'report_cards.*' => 'image|max:4096',
        ]);

        $wizardToken = $this->wizardData()['token'] ?? ($this->wizardData()['token'] = (string) Str::uuid());

        $reportCards = [];
        $gradesPerSubject = [];

        foreach ($request->file('report_cards') as $index => $file) {
            $path = $file->storeAs(
                "ppdb/temp/{$wizardToken}",
                'report_card_' . ($index + 1) . '_' . time() . '.' . $file->getClientOriginalExtension(),
                'public'
            );

            $absolutePath = storage_path('app/public/' . $path);

            // ===== DEBUG: catat info dasar sebelum coba OCR =====
            \Illuminate\Support\Facades\Log::info('PPDB OCR DEBUG: mulai proses foto', [
                'path' => $path,
                'absolute_path' => $absolutePath,
                'file_exists' => file_exists($absolutePath) ? 'YA' : 'TIDAK ADA',
                'file_size' => file_exists($absolutePath) ? filesize($absolutePath) . ' bytes' : '-',
            ]);

            $ocrData = ['raw_text' => '', 'grades' => [], 'confidence' => 0];

            try {
                $ocrData = $ocrService->extractFromPath($absolutePath);

                // ===== DEBUG: catat hasil OCR mentah =====
                \Illuminate\Support\Facades\Log::info('PPDB OCR DEBUG: hasil ekstraksi', [
                    'raw_text_length' => strlen($ocrData['raw_text']),
                    'raw_text_preview' => substr($ocrData['raw_text'], 0, 500),
                    'grades_found' => $ocrData['grades'],
                    'confidence' => $ocrData['confidence'],
                ]);
            } catch (\Throwable $e) {
                // ===== DEBUG: catat exception LENGKAP kalau gagal =====
                \Illuminate\Support\Facades\Log::error('PPDB OCR DEBUG: GAGAL total', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                report($e);
            }

            $reportCards[] = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
                'raw_text' => $ocrData['raw_text'],
                'grades' => $ocrData['grades'],
                'confidence' => $ocrData['confidence'],
            ];

            foreach ($ocrData['grades'] as $subject => $value) {
                $gradesPerSubject[$subject][] = $value;
            }
        }

        $averagedGrades = [];
        foreach ($gradesPerSubject as $subject => $values) {
            $averagedGrades[$subject] = round(array_sum($values) / count($values), 2);
        }

        $overallConfidence = count($reportCards) > 0
            ? round(array_sum(array_column($reportCards, 'confidence')) / count($reportCards), 2)
            : 0;

        $this->putWizardData([
            'token' => $wizardToken,
            'report_cards' => $reportCards,
            'ocr_confidence' => $overallConfidence,
            'grades' => $averagedGrades,
        ]);

        return redirect()->route('ppdb.wizard.ocrReview');
    }

    // ============ LANGKAH 5: SISWA MENGECEK & KONFIRMASI HASIL OCR ============
    public function ocrReviewForm(OcrService $ocrService)
    {
        if (empty($this->wizardData()['report_cards'])) {
            return redirect()->route('ppdb.wizard.reportCard')->with('error', 'Upload foto rapor terlebih dahulu.');
        }

        return view('ppdb.wizard.step5-ocr-review', [
            'subjects' => $ocrService->getSubjects(),
            'grades' => $this->wizardData()['grades'] ?? [],
            'confidence' => $this->wizardData()['ocr_confidence'] ?? 0,
        ]);
    }

    public function ocrReviewStore(Request $request, SawService $sawService)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // Nilai final versi siswa (sudah dikoreksi kalau ada yang salah baca)
        $confirmedGrades = array_filter($validated['grades'], fn ($v) => $v !== null && $v !== '');

        // Langsung hitung SAW dari nilai yang sudah dikonfirmasi ini
        $sawCalculation = $sawService->calculateFromGrades($confirmedGrades);

        $this->putWizardData([
            'grades' => $confirmedGrades,
            'grades_confirmed' => true,
            'saw_scores' => $sawCalculation['scores'],
            'recommended_slug' => $sawCalculation['recommended_slug'],
        ]);

        return redirect()->route('ppdb.wizard.recommendation');
    }

    // ============ LANGKAH 6: TAMPILKAN REKOMENDASI JURUSAN ============
    public function recommendationShow()
    {
        $data = $this->wizardData();

        if (empty($data['recommended_slug'])) {
            return redirect()->route('ppdb.wizard.ocrReview')->with('error', 'Konfirmasi nilai terlebih dahulu.');
        }

        $recommendedMajor = Major::where('slug', $data['recommended_slug'])->first();
        $majors = Major::orderBy('name')->get();

        return view('ppdb.wizard.step6-recommendation', [
            'recommendedMajor' => $recommendedMajor,
            'scores' => $data['saw_scores'] ?? [],
            'majors' => $majors,
        ]);
    }

    // ============ LANGKAH 7: SISWA MEMILIH JURUSAN (final) ============
    public function majorChoiceForm()
    {
        $data = $this->wizardData();
        $majors = Major::orderBy('name')->get();
        $recommendedSlug = $data['recommended_slug'] ?? null;

        return view('ppdb.wizard.step7-major-choice', compact('majors', 'recommendedSlug'));
    }

    // ============ SUBMIT FINAL: simpan semua ke database, generate nomor pendaftaran ============
    public function submitFinal(Request $request, SawService $sawService)
    {
        $validated = $request->validate([
            'major_choice_1' => 'required|exists:majors,id',
            'major_choice_2' => 'nullable|exists:majors,id|different:major_choice_1',
            'major_choice_3' => 'nullable|exists:majors,id|different:major_choice_1|different:major_choice_2',
        ]);

        $data = $this->wizardData();

        if (empty($data['biodata']) || empty($data['parents'])) {
            return redirect()->route('ppdb.wizard.biodata')->with('error', 'Data pendaftaran belum lengkap, silakan ulangi dari awal.');
        }

        $registration = DB::transaction(function () use ($data, $validated) {

            // Langkah 10 & 11: submit + generate nomor pendaftaran (otomatis lewat model event)
            $registration = Registration::create(['status' => 'submitted']);

            $registration->biodata()->create($data['biodata']);
            $registration->parentData()->create($data['parents']);

            // Pindahkan dokumen dari folder temp ke folder final milik pendaftaran ini
            foreach (($data['documents'] ?? []) as $field => $doc) {
                $registration->documents()->create([
                    'document_type' => $doc['label'],
                    'file_path' => $doc['path'],
                    'file_name' => $doc['name'],
                ]);
            }

            // Simpan SEMUA foto rapor yang diupload (bisa lebih dari 1 semester)
            // beserta hasil OCR mentah masing-masing foto (buat arsip/histori).
            foreach (($data['report_cards'] ?? []) as $index => $rc) {
                $reportCard = $registration->reportCards()->create([
                    'file_path' => $rc['path'],
                    'file_name' => $rc['name'] ?? 'rapor.jpg',
                    'uploaded_at' => now(),
                ]);

                $reportCard->ocrResult()->create([
                    'raw_text' => $rc['raw_text'] ?? '',
                    'extracted_data' => $rc['grades'] ?? [],
                    // Nilai gabungan (rata-rata semua semester) yang sudah dikonfirmasi siswa
                    // dianggap "final" — ditandai confirmed di foto pertama sebagai acuan utama.
                    'confidence_score' => $rc['confidence'] ?? 0,
                    'is_confirmed' => $index === 0, // foto pertama jadi acuan status konfirmasi
                ]);
            }


            // Simpan hasil SAW yang sudah dihitung di langkah 5
            if (!empty($data['grades'])) {
                $sawService->saveResult($registration, $data['grades']);
            }

            // Simpan pilihan jurusan final
            foreach ([1, 2, 3] as $order) {
                $majorId = $validated["major_choice_{$order}"] ?? null;
                if ($majorId) {
                    $registration->majorChoices()->create([
                        'major_id' => $majorId,
                        'choice_order' => $order,
                    ]);
                }
            }

            return $registration;
        });

        session()->forget($this->sessionKey); // bersihkan data wizard, sudah pindah semua ke database

        return redirect()->route('ppdb.wizard.result', $registration->registration_number);
    }

    // ============ HASIL AKHIR: nomor pendaftaran + download bukti PDF ============
    public function result(string $registrationNumber)
    {
        $registration = Registration::with(['biodata', 'majorChoices.major', 'sawResult.recommendedMajor'])
            ->where('registration_number', $registrationNumber)
            ->firstOrFail();

        return view('ppdb.wizard.result', compact('registration'));
    }

    public function downloadProofPdf(string $registrationNumber)
    {
        $registration = Registration::with(['biodata', 'parentData', 'majorChoices.major', 'sawResult.recommendedMajor'])
            ->where('registration_number', $registrationNumber)
            ->firstOrFail();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ppdb.wizard.proof-pdf', compact('registration'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Bukti-Pendaftaran-' . $registration->registration_number . '.pdf');
    }
}