<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\PPDB\ReportCard;
use App\Models\PPDB\OcrResult;

/**
 * Service untuk membaca teks & nilai mata pelajaran dari foto rapor/SKL menggunakan Tesseract OCR.
 */
class OcrService
{
    /**
     * Daftar mata pelajaran yang dicoba dikenali. Ditambah beberapa alternatif nama
     * mapel yang umum muncul di rapor SMP maupun SKL/rapor format SMK, supaya lebih
     * fleksibel terhadap variasi format dokumen asli sekolah.
     */
    protected array $subjects = [
        'Matematika',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'IPA',
        'IPS',
        // Alternatif/pecahan IPA-IPS yang kadang muncul terpisah di beberapa format rapor:
        'Fisika',
        'Kimia',
        'Biologi',
        'Sejarah Indonesia',
        'Pendidikan Pancasila',
    ];

    public function extractFromPath(string $absoluteImagePath): array
    {
        $rawText = $this->extractText($absoluteImagePath);
        $grades = $this->parseGrades($rawText);
        $confidence = $this->estimateConfidence($grades);

        return [
            'raw_text' => $rawText,
            'grades' => $grades,
            'confidence' => $confidence,
        ];
    }

    /**
     * Baca BANYAK foto sekaligus (misal rapor beberapa semester/halaman), gabungkan
     * teksnya, lalu cari nilai mata pelajaran dari GABUNGAN semua halaman itu.
     * Ini penting karena 1 mapel bisa saja cuma muncul di salah satu halaman/foto,
     * bukan di semuanya.
     */
    public function extractFromPaths(array $absoluteImagePaths): array
    {
        $combinedText = '';

        foreach ($absoluteImagePaths as $path) {
            $combinedText .= $this->extractText($path) . "\n";
        }

        $grades = $this->parseGrades($combinedText);
        $confidence = $this->estimateConfidence($grades);

        return [
            'raw_text' => $combinedText,
            'grades' => $grades,
            'confidence' => $confidence,
        ];
    }

    public function process(ReportCard $reportCard): OcrResult
    {
        $imagePath = storage_path('app/public/' . $reportCard->file_path);
        $result = $this->extractFromPath($imagePath);

        return OcrResult::updateOrCreate(
            ['report_card_id' => $reportCard->id],
            [
                'raw_text' => $result['raw_text'],
                'extracted_data' => $result['grades'],
                'confidence_score' => $result['confidence'],
                'is_confirmed' => false,
            ]
        );
    }

    protected function extractText(string $imagePath): string
    {
        try {
            return (new TesseractOCR($imagePath))
                ->lang('ind', 'eng')
                ->psm(6)
                ->run();
        } catch (\Exception $e) {
            report($e);
            return '';
        }
    }

    /**
     * PERBAIKAN: nilai rapor Indonesia biasanya ditulis pakai KOMA sebagai
     * pemisah desimal (contoh: "90,00" atau "84,38"), BUKAN titik seperti format
     * Inggris. Regex versi sebelumnya salah ambil angka DI BELAKANG koma
     * (mengira "90,00" -> ambil "00"). Sekarang diperbaiki: coba cari pola
     * "angka,angka" atau "angka.angka" dulu dan ambil BAGIAN DEPAN sebelum
     * koma/titik (itu nilai utamanya) — baru kalau tidak ketemu, fallback ke
     * angka polos biasa.
     */
    protected function parseGrades(string $text): array
    {
        $results = [];
        $lines = preg_split('/\r\n|\r|\n/', $text);

        foreach ($this->subjects as $subject) {
            foreach ($lines as $line) {
                if (stripos($line, $subject) !== false) {
                    $value = null;

                    // Coba dulu pola "NN,NN" atau "NN.NN" (format nilai dengan desimal)
                    if (preg_match('/(\d{1,3})[,.](\d{1,2})(?!\d)/', $line, $match)) {
                        $value = (float) $match[1]; // ambil bagian SEBELUM koma/titik
                    }
                    // Kalau tidak ada format desimal, cari angka polos 1-3 digit terakhir di baris
                    elseif (preg_match('/(\d{1,3})(?!.*\d)/', $line, $match)) {
                        $value = (float) $match[1];
                    }

                    if ($value !== null && $value >= 0 && $value <= 100) {
                        $results[$subject] = $value;
                        break;
                    }
                }
            }
        }

        return $results;
    }

    protected function estimateConfidence(array $extractedGrades): float
    {
        // Confidence dihitung dari 5 mapel INTI saja (Matematika, B.Indo, B.Inggris, IPA, IPS)
        // supaya tidak "dihukum" kalau mapel tambahan (Fisika/Kimia/dst) tidak ketemu.
        $coreSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS'];
        $foundCore = count(array_intersect_key($extractedGrades, array_flip($coreSubjects)));

        return round(($foundCore / count($coreSubjects)) * 100, 2);
    }

    public function getSubjects(): array
    {
        // Yang ditampilkan di form konfirmasi tetap cuma 5 mapel inti,
        // biar formnya tidak kepanjangan buat siswa isi manual.
        return ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS'];
    }
}