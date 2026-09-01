<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PPDB\Registration;
use App\Models\PPDB\ReportCard;
use App\Services\OcrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbController extends Controller
{
    // Tampilkan form pendaftaran
    public function create()
    {
        $majors = Major::orderBy('name')->get();
        return view('ppdb.create', compact('majors'));
    }

    // Proses submit form pendaftaran (biodata, ortu, berkas, rapor, pilihan jurusan)
    public function store(Request $request, OcrService $ocrService)
    {
        $data = $request->validate([
            // Biodata
            'nik' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'religion' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'school_origin' => 'nullable|string|max:255',

            // Data orang tua
            'father_name' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:30',
            'father_occupation' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:30',
            'mother_occupation' => 'nullable|string|max:100',

            // Berkas dokumen
            'doc_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_akte' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

            // Foto rapor (bahan OCR)
            'report_card' => 'nullable|image|max:4096',

            // Pilihan jurusan (urut prioritas)
            'major_choice_1' => 'required|exists:majors,id',
            'major_choice_2' => 'nullable|exists:majors,id|different:major_choice_1',
            'major_choice_3' => 'nullable|exists:majors,id|different:major_choice_1|different:major_choice_2',
        ]);

        $registration = DB::transaction(function () use ($request, $data) {

            $registration = Registration::create(['status' => 'submitted']);

            $registration->biodata()->create([
                'nik' => $data['nik'] ?? null,
                'name' => $data['name'],
                'place_of_birth' => $data['place_of_birth'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
                'religion' => $data['religion'] ?? null,
                'address' => $data['address'] ?? null,
                'school_origin' => $data['school_origin'] ?? null,
            ]);

            $registration->parentData()->create([
                'father_name' => $data['father_name'] ?? null,
                'father_phone' => $data['father_phone'] ?? null,
                'father_occupation' => $data['father_occupation'] ?? null,
                'mother_name' => $data['mother_name'] ?? null,
                'mother_phone' => $data['mother_phone'] ?? null,
                'mother_occupation' => $data['mother_occupation'] ?? null,
            ]);

            // Simpan tiap berkas yang diupload (kalau ada)
            $documentFields = [
                'doc_kk' => 'Kartu Keluarga',
                'doc_akte' => 'Akte Kelahiran',
                'doc_ijazah' => 'Ijazah / Surat Keterangan Lulus',
                'doc_foto' => 'Pas Foto',
            ];

            foreach ($documentFields as $field => $label) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $file->store('ppdb/documents', 'public');

                    $registration->documents()->create([
                        'document_type' => $label,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            // Simpan pilihan jurusan sesuai urutan prioritas
            foreach ([1, 2, 3] as $order) {
                $majorId = $data["major_choice_{$order}"] ?? null;
                if ($majorId) {
                    $registration->majorChoices()->create([
                        'major_id' => $majorId,
                        'choice_order' => $order,
                    ]);
                }
            }

            return $registration;
        });

        // Upload & proses foto rapor (di luar transaction, karena OCR bisa gagal/lama
        // dan tidak boleh sampai membatalkan data pendaftaran yang sudah tersimpan)
        if ($request->hasFile('report_card')) {
            $file = $request->file('report_card');
            $path = $file->store('ppdb/report-cards', 'public');

            $reportCard = ReportCard::create([
                'registration_id' => $registration->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'uploaded_at' => now(),
            ]);

            try {
                $ocrService->process($reportCard);
            } catch (\Throwable $e) {
                // OCR gagal (misal Tesseract belum ter-install di server) — jangan sampai
                // menggagalkan pendaftaran. Panitia bisa proses OCR manual nanti dari admin.
                report($e);
            }
        }

        return redirect()
            ->route('ppdb.applicants.show', $registration->registration_number)
            ->with('success', 'Pendaftaran berhasil! Simpan nomor pendaftaran Anda baik-baik.');
    }

    // Halaman status pendaftaran (dicek pakai nomor pendaftaran)
    public function show(string $registrationNumber)
    {
        $registration = Registration::with([
                'biodata', 'parentData', 'documents', 'reportCards.ocrResult',
                'majorChoices.major', 'sawResult.recommendedMajor',
            ])
            ->where('registration_number', $registrationNumber)
            ->firstOrFail();

        return view('ppdb.show', compact('registration'));
    }
}