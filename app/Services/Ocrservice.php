<?php

namespace App\Services;

use App\Models\PPDB\OcrResult;
use App\Models\PPDB\ReportCard;
use thiagoalessio\TesseractOCR\TesseractOCR;

/**
 * Service untuk membaca teks dan nilai mata pelajaran
 * dari foto rapor/SKL menggunakan Tesseract OCR.
 */
class OcrService
{
    /**
     * Mapel inti yang digunakan untuk proses SPK/SAW.
     */
    protected array $subjects = [
        'Matematika',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'IPA',
        'IPS',
    ];

    /**
     * Ekstrak teks dan nilai dari satu foto.
     */
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
     * Ekstrak teks dan nilai dari beberapa foto rapor.
     *
     * Semua teks digabung terlebih dahulu agar nilai dari
     * beberapa halaman/semester dapat diproses bersama.
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

    /**
     * Proses satu data rapor dan simpan hasil OCR ke database.
     */
    public function process(ReportCard $reportCard): OcrResult
    {
        $imagePath = storage_path(
            'app/public/' . $reportCard->file_path
        );

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

    /**
     * Jalankan Tesseract OCR.
     *
     * Tesseract diarahkan langsung ke lokasi instalasi Windows
     * supaya tetap bisa dipanggil oleh Laravel web server.
     *
     * PSM 11 digunakan karena foto rapor memiliki teks dan
     * kolom nilai yang tersebar di berbagai bagian halaman.
     */
    protected function extractText(string $imagePath): string
    {
        try {
            $tesseract = new TesseractOCR($imagePath);

            $tesseract
                ->executable('D:\Program Files\Tesseract-OCR\tesseract.exe')
                ->tessdataDir('D:\Program Files\Tesseract-OCR\tessdata')
                ->lang('ind', 'eng')
                ->psm(11);

            $result = $tesseract->run();

            \Log::info('OCR berhasil dijalankan', [
                'image' => $imagePath,
                'text_length' => strlen($result),
            ]);

            return $result;

        } catch (\Throwable $e) {

            \Log::error('OCR gagal dijalankan', [
                'image' => $imagePath,
                'error' => $e->getMessage(),
            ]);

            report($e);

            return '';
        }
    }

    /**
     * Ambil nilai mata pelajaran dari hasil OCR.
     *
     * OCR pada tabel rapor tidak selalu mempertahankan posisi
     * kolom dengan sempurna. Karena itu parser mencoba:
     *
     * 1. Nilai setelah nama mapel.
     * 2. Nilai beberapa baris setelah nama mapel.
     * 3. Nilai sebelum nama mapel.
     */
    protected function parseGrades(string $text): array
    {
        $results = [];

        if (trim($text) === '') {
            return $results;
        }

        $lines = preg_split(
            '/\r\n|\r|\n/',
            $text
        );

        foreach ($this->subjects as $subject) {

            foreach ($lines as $index => $line) {

                if (stripos($line, $subject) === false) {
                    continue;
                }

                $value = null;

                /*
                 * =====================================================
                 * POLA 1
                 * Nama mapel dan nilai berada pada baris yang sama.
                 *
                 * Contoh:
                 *
                 * Matematika (Umum) 87
                 * =====================================================
                 */

                $subjectPosition = stripos($line, $subject);

                $afterSubject = substr(
                    $line,
                    $subjectPosition + strlen($subject)
                );

                $value = $this->findGradeInText($afterSubject);

                /*
                 * =====================================================
                 * POLA 2
                 * Nilai berada beberapa baris SETELAH nama mapel.
                 *
                 * Contoh OCR:
                 *
                 * Bahasa Indonesia
                 *
                 * 90
                 * =====================================================
                 */

                if ($value === null) {

                    for ($offset = 1; $offset <= 12; $offset++) {

                        if (!isset($lines[$index + $offset])) {
                            break;
                        }

                        $nextLine = trim(
                            $lines[$index + $offset]
                        );

                        if ($nextLine === '') {
                            continue;
                        }

                        /*
                         * Kalau menemukan mapel lain,
                         * jangan mengambil nilai milik mapel tersebut.
                         */
                        if ($this->containsAnotherSubject(
                            $nextLine,
                            $subject
                        )) {
                            break;
                        }

                        $value = $this->findGradeInText(
                            $nextLine
                        );

                        if ($value !== null) {
                            break;
                        }
                    }
                }

                /*
                 * =====================================================
                 * POLA 3
                 * Nilai berada SEBELUM nama mapel.
                 *
                 * Contoh OCR:
                 *
                 * 90
                 *
                 * Bahasa Indonesia
                 *
                 * =====================================================
                 */

                if ($value === null) {

                    for ($offset = 1; $offset <= 12; $offset++) {

                        if (!isset($lines[$index - $offset])) {
                            break;
                        }

                        $previousLine = trim(
                            $lines[$index - $offset]
                        );

                        if ($previousLine === '') {
                            continue;
                        }

                        if ($this->containsAnotherSubject(
                            $previousLine,
                            $subject
                        )) {
                            break;
                        }

                        $value = $this->findGradeInText(
                            $previousLine
                        );

                        if ($value !== null) {
                            break;
                        }
                    }
                }

                /*
                 * Kalau nilai ditemukan, simpan.
                 */
                if ($value !== null) {

                    $results[$subject] = $value;

                    break;
                }
            }
        }

        return $results;
    }

    /**
     * Cari angka yang masuk akal sebagai nilai rapor.
     *
     * Hanya nilai 60-100 yang diprioritaskan supaya nomor:
     *
     * - nomor mapel
     * - nomor halaman
     * - tahun
     * - nomor peserta
     *
     * tidak mudah dianggap sebagai nilai.
     */
    protected function findGradeInText(string $text): ?float
    {
        /*
         * Mendukung:
         *
         * 90
         * 90,00
         * 90.00
         */
        preg_match_all(
            '/\b(\d{1,3})(?:[,.]\d{1,2})?\b/',
            $text,
            $matches
        );

        foreach ($matches[1] as $number) {

            $number = (float) $number;

            if ($number >= 60 && $number <= 100) {
                return $number;
            }
        }

        return null;
    }

    /**
     * Cek apakah baris mengandung nama mapel lain.
     */
    protected function containsAnotherSubject(
        string $line,
        string $currentSubject
    ): bool {
        foreach ($this->subjects as $subject) {

            if (
                $subject !== $currentSubject &&
                stripos($line, $subject) !== false
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Hitung confidence berdasarkan 5 mapel inti.
     *
     * 1 mapel = 20%
     * 2 mapel = 40%
     * 3 mapel = 60%
     * 4 mapel = 80%
     * 5 mapel = 100%
     */
    protected function estimateConfidence(
        array $extractedGrades
    ): float {
        $coreSubjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA',
            'IPS',
        ];

        $foundCore = count(
            array_intersect_key(
                $extractedGrades,
                array_flip($coreSubjects)
            )
        );

        return round(
            ($foundCore / count($coreSubjects)) * 100,
            2
        );
    }

    /**
     * Daftar mapel yang ditampilkan pada halaman
     * konfirmasi nilai.
     */
    public function getSubjects(): array
    {
        return [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA',
            'IPS',
        ];
    }
}
