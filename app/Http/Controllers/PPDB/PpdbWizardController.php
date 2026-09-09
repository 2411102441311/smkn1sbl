<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PPDB\Registration;
use App\Models\PPDB\MajorChoice;
use App\Services\OcrService;
use App\Services\SawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\PpdbPeriod;

class PpdbWizardController extends Controller
{
    /**
     * Session key untuk seluruh proses wizard PPDB.
     */
    protected string $sessionKey = 'ppdb_wizard';

    /**
     * Ambil seluruh data wizard dari session.
     */
    protected function wizardData(): array
    {
        return session($this->sessionKey, []);
    }

    /**
     * Simpan/update data wizard ke session.
     */
    protected function putWizardData(array $data): void
    {
        session([
            $this->sessionKey => array_merge(
                $this->wizardData(),
                $data
            ),
        ]);
    }

    // =========================================================
    // LANGKAH 1: BIODATA
    // =========================================================

    public function biodataForm()
    {
        return view(
            'ppdb.wizard.step1-biodata',
            [
                'old' => $this->wizardData()['biodata'] ?? [],
            ]
        );
    }

    public function biodataStore(Request $request)
    {
        $data = $request->validate([
            'nik' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'family_card_number' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:30',
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

        $this->putWizardData([
            'biodata' => $data,
        ]);

        return redirect()->route('ppdb.wizard.parents');
    }
    // =========================================================
    // LANGKAH 2: DATA ORANG TUA
    // =========================================================

    public function parentsForm()
    {
        if (
            empty(
                $this->wizardData()['biodata']
                ?? []
            )
        ) {
            return redirect()
                ->route('ppdb.wizard.biodata')
                ->with(
                    'error',
                    'Lengkapi biodata terlebih dahulu.'
                );
        }

        return view(
            'ppdb.wizard.step2-parents',
            [
                'old' =>
                    $this->wizardData()['parents']
                    ?? [],
            ]
        );
    }

    public function parentsStore(Request $request)
    {
        $data = $request->validate([
            // =========================
            // DATA AYAH
            // =========================
            'father_name' => 'nullable|string|max:255',
            'father_nik' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:30',
            'father_occupation' => 'nullable|string|max:100',

            // =========================
            // DATA IBU
            // =========================
            'mother_name' => 'nullable|string|max:255',
            'mother_nik' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:30',
            'mother_occupation' => 'nullable|string|max:100',

            // =========================
            // DATA WALI
            // =========================
            'has_guardian' => 'nullable|boolean',

            'guardian_relationship' => [
                'nullable',
                'string',
                'max:50',
                'required_if:has_guardian,1',
            ],

            'guardian_name' => [
                'nullable',
                'string',
                'max:255',
                'required_if:has_guardian,1',
            ],

            'guardian_nik' => [
                'nullable',
                'string',
                'max:20',
                'required_if:has_guardian,1',
            ],

            'guardian_phone' => [
                'nullable',
                'string',
                'max:30',
                'required_if:has_guardian,1',
            ],

            'guardian_occupation' => [
                'nullable',
                'string',
                'max:100',
                'required_if:has_guardian,1',
            ],
        ]);

        // Checkbox menghasilkan true/false.
        $data['has_guardian'] = $request->boolean('has_guardian');

        // Kalau tidak menggunakan wali,
        // pastikan data wali dikosongkan.
        if (!$data['has_guardian']) {
            $data['guardian_relationship'] = null;
            $data['guardian_name'] = null;
            $data['guardian_nik'] = null;
            $data['guardian_phone'] = null;
            $data['guardian_occupation'] = null;
        }

        // Simpan seluruh data ke session wizard.
        $this->putWizardData([
            'parents' => $data,
        ]);

        return redirect()->route('ppdb.wizard.documents');
    }

    // =========================================================
    // LANGKAH 3: UPLOAD DOKUMEN
    // =========================================================

    public function documentsForm()
    {
        if (
            empty(
                $this->wizardData()['parents']
                ?? []
            )
        ) {
            return redirect()
                ->route('ppdb.wizard.parents')
                ->with(
                    'error',
                    'Lengkapi data orang tua terlebih dahulu.'
                );
        }

        return view(
            'ppdb.wizard.step3-documents',
            [
                'uploaded' =>
                    $this->wizardData()['documents']
                    ?? [],
            ]
        );
    }

    public function documentsStore(Request $request)
    {
        $request->validate([
            'doc_kk' =>
                'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',

            'doc_akte' =>
                'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',

            'doc_ijazah' =>
                'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',

            'doc_foto' =>
                'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $documentLabels = [
            'doc_kk' => 'kk',
            'doc_akte' => 'Akte Kelahiran',
            'doc_ijazah' =>
                'Ijazah / Surat Keterangan Lulus',
            'doc_foto' => 'Pas Foto',
        ];

        $uploaded =
            $this->wizardData()['documents']
            ?? [];

        $wizardToken =
            $this->wizardData()['token']
            ?? (string) Str::uuid();

        foreach (
            $documentLabels
            as $field => $label
        ) {
            if (
                !$request->hasFile($field)
            ) {
                continue;
            }

            $file =
                $request->file($field);

            $path = $file->storeAs(
                "ppdb/temp/{$wizardToken}",
                $field .
                    '_' .
                    time() .
                    '.' .
                    $file->getClientOriginalExtension(),
                'public'
            );

            $uploaded[$field] = [
                'label' =>
                    $label,

                'path' =>
                    $path,

                'name' =>
                    $file->getClientOriginalName(),

                'mime_type' =>
                    $file->getMimeType(),

                'file_size' =>
                    $file->getSize(),
            ];
        }

        $this->putWizardData([
            'documents' => $uploaded,
            'token' => $wizardToken,
        ]);

        return redirect()->route(
            'ppdb.wizard.reportCard'
        );
    }

    // =========================================================
    // LANGKAH 4: UPLOAD FOTO RAPOR + OCR
    // =========================================================

    public function reportCardForm()
    {
        return view(
            'ppdb.wizard.step4-report-card'
        );
    }

    public function reportCardStore(
        Request $request,
        OcrService $ocrService
    ) {
        $request->validate([
            'report_cards' =>
                'required|array|min:1',

            'report_cards.*' =>
                'required|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        /*
         * Token wizard.
         */
        $wizardToken =
            $this->wizardData()['token']
            ?? (string) Str::uuid();

        /*
         * Detail setiap foto.
         */
        $reportCards = [];

        /*
         * Nilai yang ditemukan dari semua foto.
         *
         * Contoh:
         *
         * Foto 1:
         * Matematika = 89
         *
         * Foto 2:
         * Bahasa Indonesia = 77
         *
         * Foto 3:
         * Bahasa Inggris = 81
         *
         * Semua akan digabung.
         */
        $gradesPerSubject = [];

        /*
         * =========================================================
         * PROSES SETIAP FOTO
         * =========================================================
         */
        foreach (
            $request->file('report_cards')
            as $index => $file
        ) {
            /*
             * Simpan foto sementara.
             */
            $path = $file->storeAs(
                "ppdb/temp/{$wizardToken}",
                'report_card_' .
                    ($index + 1) .
                    '_' .
                    time() .
                    '.' .
                    $file->getClientOriginalExtension(),
                'public'
            );

            /*
             * Default jika OCR gagal.
             */
            $ocrData = [
                'raw_text' => '',
                'grades' => [],
                'confidence' => 0,
            ];

            /*
             * Jalankan OCR.
             */
            try {
                $ocrData =
                    $ocrService->extractFromPath(
                        storage_path(
                            'app/public/' . $path
                        )
                    );
                    
            } catch (\Throwable $e) {

                report($e);

                \Log::error(
                    'OCR report card gagal.',
                    [
                        'path' => $path,
                        'error' =>
                            $e->getMessage(),
                    ]
                );
            }

            /*
             * Simpan detail hasil OCR
             * untuk foto ini.
             */
            $reportCards[] = [
                'path' => $path,

                'name' =>
                    $file->getClientOriginalName(),

                'mime_type' =>
                    $file->getMimeType(),

                'file_size' =>
                    $file->getSize(),

                'raw_text' =>
                    $ocrData['raw_text']
                    ?? '',

                'grades' =>
                    $ocrData['grades']
                    ?? [],

                'confidence' =>
                    $ocrData['confidence']
                    ?? 0,
            ];

            /*
             * =====================================================
             * GABUNGKAN NILAI BERDASARKAN MAPEL
             * =====================================================
             */
            foreach (
                ($ocrData['grades'] ?? [])
                as $subject => $value
            ) {
                /*
                 * Abaikan nilai kosong.
                 */
                if (
                    $value === null ||
                    $value === ''
                ) {
                    continue;
                }

                /*
                 * Pastikan nilai berupa angka.
                 */
                if (!is_numeric($value)) {
                    continue;
                }

                $gradesPerSubject[
                    $subject
                ][] = (float) $value;
            }
        }

        /*
         * =========================================================
         * RATA-RATA NILAI DARI SEMUA FOTO
         * =========================================================
         *
         * Kalau satu mapel muncul di beberapa rapor,
         * nilainya dirata-ratakan.
         */
        $averagedGrades = [];

        foreach (
            $gradesPerSubject
            as $subject => $values
        ) {
            if (empty($values)) {
                continue;
            }

            $averagedGrades[
                $subject
            ] = round(
                array_sum($values) /
                    count($values),
                2
            );
        }

        /*
         * =========================================================
         * CONFIDENCE HASIL GABUNGAN
         * =========================================================
         *
         * Yang dihitung adalah 5 nilai inti:
         *
         * 1. Matematika
         * 2. Bahasa Indonesia
         * 3. Bahasa Inggris
         * 4. IPA
         * 5. IPS
         *
         * Jadi bukan confidence setiap foto.
         *
         * Misalnya:
         *
         * Foto 1 = Matematika
         * Foto 2 = Bahasa Indonesia
         * Foto 3 = Bahasa Inggris
         * Foto 4 = IPA
         * Foto 5 = IPS
         *
         * Hasil akhir = 100%.
         */
        $coreSubjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA',
            'IPS',
        ];

        $foundCore = 0;

        foreach (
            $coreSubjects
            as $subject
        ) {
            if (
                isset(
                    $averagedGrades[$subject]
                ) &&
                $averagedGrades[$subject] !== null
            ) {
                $foundCore++;
            }
        }

        $overallConfidence =
            round(
                (
                    $foundCore /
                    count($coreSubjects)
                ) * 100,
                2
            );

        /*
         * =========================================================
         * SIMPAN HASIL KE SESSION
         * =========================================================
         */
        $this->putWizardData([
            'token' =>
                $wizardToken,

            /*
             * Detail semua foto.
             */
            'report_cards' =>
                $reportCards,

            /*
             * Confidence berdasarkan
             * hasil semua foto.
             */
            'ocr_confidence' =>
                $overallConfidence,

            /*
             * Nilai gabungan yang akan
             * ditampilkan di konfirmasi.
             */
            'grades' =>
                $averagedGrades,

            /*
             * Belum dikonfirmasi siswa.
             */
            'grades_confirmed' =>
                false,
        ]);

        return redirect()->route(
            'ppdb.wizard.ocrReview'
        );
    }

    // =========================================================
    // LANGKAH 5: KONFIRMASI HASIL OCR
    // =========================================================

    public function ocrReviewForm(
        OcrService $ocrService
    ) {
        $data =
            $this->wizardData();

        if (
            empty(
                $data['report_cards']
                ?? []
            )
        ) {
            return redirect()
                ->route(
                    'ppdb.wizard.reportCard'
                )
                ->with(
                    'error',
                    'Upload foto rapor terlebih dahulu.'
                );
        }

        return view(
            'ppdb.wizard.step5-ocr-review',
            [
                'subjects' =>
                    $ocrService->getSubjects(),

                'grades' =>
                    $data['grades']
                    ?? [],

                'confidence' =>
                    $data['ocr_confidence']
                    ?? 0,
            ]
        );
    }

    public function ocrReviewStore(
        Request $request,
        SawService $sawService
    ) {
        $validated =
            $request->validate([
                'grades' =>
                    'required|array',

                'grades.*' =>
                    'nullable|numeric|min:0|max:100',
            ]);

        /*
         * Ambil hanya nilai yang benar-benar diisi.
         */
        $confirmedGrades =
            array_filter(
                $validated['grades'],
                fn ($value) =>
                    $value !== null &&
                    $value !== ''
            );

        /*
         * Hitung SAW berdasarkan nilai
         * yang sudah dikonfirmasi.
         */
        $sawCalculation =
            $sawService->calculateFromGrades(
                $confirmedGrades
            );

        /*
         * Simpan hasil konfirmasi.
         */
        $this->putWizardData([
            'grades' =>
                $confirmedGrades,

            'grades_confirmed' =>
                true,

            'saw_scores' =>
                $sawCalculation['scores'],

            'recommended_slug' =>
                $sawCalculation['recommended_slug'],
        ]);

        return redirect()->route(
            'ppdb.wizard.recommendation'
        );
    }

    // =========================================================
    // LANGKAH 6: REKOMENDASI JURUSAN
    // =========================================================

    public function recommendationShow()
    {
        $data =
            $this->wizardData();

        if (
            empty(
                $data['recommended_slug']
                ?? null
            )
        ) {
            return redirect()
                ->route(
                    'ppdb.wizard.ocrReview'
                )
                ->with(
                    'error',
                    'Konfirmasi nilai terlebih dahulu.'
                );
        }

        $recommendedMajor =
            Major::where(
                'slug',
                $data['recommended_slug']
            )->first();

        $majors =
            Major::orderBy('name')
                ->get();

        return view(
            'ppdb.wizard.step6-recommendation',
            [
                'recommendedMajor' =>
                    $recommendedMajor,

                'scores' =>
                    $data['saw_scores']
                    ?? [],

                'majors' =>
                    $majors,
            ]
        );
    }

    // =========================================================
    // LANGKAH 7: PILIH JURUSAN
    // =========================================================

    public function majorChoiceForm()
    {
        $data =
            $this->wizardData();

        $majors =
            Major::orderBy('name')
                ->get();

        $recommendedSlug =
            $data['recommended_slug']
            ?? null;

        return view(
            'ppdb.wizard.step7-major-choice',
            compact(
                'majors',
                'recommendedSlug'
            )
        );
    }

    // =========================================================
    // SUBMIT FINAL
    // =========================================================

    public function submitFinal(
        Request $request,
        SawService $sawService
    ) {
        $validated =
            $request->validate([
                'major_choice_1' =>
                    'required|exists:majors,id',

                'major_choice_2' =>
                    'nullable|exists:majors,id|different:major_choice_1',

                'major_choice_3' =>
                    'nullable|exists:majors,id|different:major_choice_1|different:major_choice_2',
            ]);

        $data =
            $this->wizardData();

        /*
         * Pastikan biodata dan orang tua sudah ada.
         */
        if (
            empty($data['biodata'] ?? []) ||
            empty($data['parents'] ?? [])
        ) {
            return redirect()
                ->route(
                    'ppdb.wizard.biodata'
                )
                ->with(
                    'error',
                    'Data pendaftaran belum lengkap, silakan ulangi dari awal.'
                );
        }

        /*
         * =========================================================
         * TRANSACTION
         * =========================================================
         */
        $registration =
            DB::transaction(
                function () use (
                    $data,
                    $validated,
                    $sawService
                ) {

                    // =================================================
                    // 1. BUAT APPLICANT
                    // =================================================

                    $biodata =
                        $data['biodata'];

                    $applicant =
                        \App\Models\PPDB\Applicant::create([
                            'full_name' =>
                                $biodata['name']
                                ?? '',

                            'nisn' =>
                                $biodata['nisn']
                                ?? null,

                            'email' =>
                                $biodata['email']
                                ?? null,

                            'phone' =>
                                $biodata['phone']
                                ?? null,

                            'address' =>
                                $biodata['address']
                                ?? null,

                            'previous_school' =>
                                $biodata['school_origin']
                                ?? null,
                        ]);

                    // =================================================
                    // 2. BUAT REGISTRATION
                    // =================================================

                    $activePeriod = PpdbPeriod::where('is_active', true)->first();

                        if (!$activePeriod) {
                            throw new \Exception('Periode PPDB aktif belum tersedia.');
                        }

                        $registration = Registration::create([
                            'applicant_id' => $applicant->id,

                            'registration_number' =>
                                $applicant->registration_number,

                            'period_id' => $activePeriod->id,

                            'status' => 'submitted',
                        ]);

                    // =================================================
                    // 3. SIMPAN BIODATA
                    // =================================================

                    $registration
                        ->biodata()
                        ->create(
                            $data['biodata']
                        );

                    // =================================================
                    // 4. SIMPAN DATA ORANG TUA
                    // =================================================

                    $registration
                        ->parentData()
                        ->create(
                            $data['parents']
                        );

                    // =================================================
                    // 5. SIMPAN DOKUMEN
                    // =================================================

                    foreach (
                        (
                            $data['documents']
                            ?? []
                        ) as $field => $doc
                    ) {

                        $documentType =
                            match (
                                strtolower(
                                    trim(
                                        $doc['label']
                                        ?? ''
                                    )
                                )
                            ) {

                                'kartu keluarga',
                                'kk'
                                    => 'kk',

                                'akte kelahiran',
                                'akta kelahiran'
                                    => 'akta_kelahiran',

                                'rapor'
                                    => 'rapor',

                                'pas foto',
                                'pasfoto'
                                    => 'pas_foto',

                                'kip'
                                    => 'kip',

                                'surat keterangan lulus',
                                'ijazah / surat keterangan lulus'
                                    => 'surat_keterangan_lulus',

                                default
                                    => 'lainnya',
                            };

                        $registration
                            ->documents()
                            ->create([
                                'document_type' =>
                                    $documentType,

                                'file_path' =>
                                    $doc['path'],

                                'file_name' =>
                                    $doc['name']
                                    ?? null,
                            ]);
                    }

                    // =================================================
                    // 6. SIMPAN SEMUA FOTO RAPOR + OCR
                    // =================================================

                    foreach (
                        (
                            $data['report_cards']
                            ?? []
                        ) as $index => $rc
                    ) {

                        $reportCard =
                            $registration
                                ->reportCards()
                                ->create([
                                    'file_path' =>
                                        $rc['path'],

                                    'file_name' =>
                                        $rc['name']
                                        ?? 'rapor.jpg',

                                    'mime_type' =>
                                        $rc['mime_type']
                                        ?? null,

                                    'file_size' =>
                                        $rc['file_size']
                                        ?? null,
                                ]);

                        $reportCard
                            ->ocrResult()
                            ->create([
                                'raw_text' =>
                                    $rc['raw_text']
                                    ?? '',

                                'extracted_data' =>
                                    $rc['grades']
                                    ?? [],

                                'confidence_score' =>
                                    $rc['confidence']
                                    ?? 0,

                                /*
                                 * Hanya foto pertama
                                 * ditandai sebagai confirmed
                                 * sesuai struktur lama.
                                 */
                                'is_confirmed' =>
                                    $index === 0,
                            ]);
                    }

                    // =================================================
                    // 7. SIMPAN HASIL SAW
                    // =================================================

                    if (
                        !empty(
                            $data['grades']
                            ?? []
                        )
                    ) {

                        $sawService->saveResult(
                            $registration,
                            $data['grades']
                        );
                    }

                    // =================================================
                    // 8. SIMPAN PILIHAN JURUSAN
                    // =================================================

                    foreach (
                        [1, 2, 3]
                        as $order
                    ) {

                        $majorId =
                            $validated[
                                "major_choice_{$order}"
                            ]
                            ?? null;

                        if (!$majorId) {
                            continue;
                        }

                        $registration
                            ->majorChoices()
                            ->create([
                                'major_id' =>
                                    $majorId,

                                'choice_order' =>
                                    $order,
                            ]);
                    }

                    return $registration;
                }
            );

        // =========================================================
        // 9. HAPUS SESSION WIZARD
        // =========================================================

        session()->forget(
            $this->sessionKey
        );

        // =========================================================
        // 10. HALAMAN HASIL
        // =========================================================

        return redirect()->route(
            'ppdb.wizard.result',
            $registration->registration_number
        );
    }

    // =========================================================
    // HASIL AKHIR
    // =========================================================

    public function result(
        string $registrationNumber
    ) {
        $registration =
            Registration::with([
                'biodata',
                'majorChoices.major',
                'sawResult.recommendedMajor',
            ])
            ->where(
                'registration_number',
                $registrationNumber
            )
            ->firstOrFail();

        return view(
            'ppdb.wizard.result',
            compact('registration')
        );
    }

    // =========================================================
    // DOWNLOAD BUKTI PDF
    // =========================================================

    public function downloadProofPdf(
        string $registrationNumber
    ) {
        $registration =
            Registration::with([
                'biodata',
                'parentData',
                'majorChoices.major',
                'sawResult.recommendedMajor',
            ])
            ->where(
                'registration_number',
                $registrationNumber
            )
            ->firstOrFail();

        $pdf =
            \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'ppdb.wizard.proof-pdf',
                compact('registration')
            )
            ->setPaper(
                'a4',
                'portrait'
            );

        return $pdf->download(
            'Bukti-Pendaftaran-' .
            $registration->registration_number .
            '.pdf'
        );
    }
}