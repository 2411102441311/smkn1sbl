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
                ->executable('C:\Program Files\Tesseract-OCR\tesseract.exe')
                ->tessdataDir('C:\Program Files\Tesseract-OCR\tessdata')
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

    private function parseGrades(string $text): array
{
    $subjects = [
        'Matematika',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'IPA',
        'IPS',
    ];

    // Normalisasi teks OCR
    $text = str_replace(["\r\n", "\r"], "\n", $text);
    $text = preg_replace('/[ \t]+/', ' ', $text);

    $lines = array_values(array_filter(
        array_map('trim', explode("\n", $text)),
        fn ($line) => $line !== ''
    ));

    $grades = [];

    foreach ($subjects as $subject) {
        $subjectKey = strtolower($subject);
        $foundGrade = null;

        /*
         * ============================================================
         * 1. CARI MAPEL DAN NILAI DI BARIS YANG SAMA
         * Contoh:
         * Matematika 85
         * Bahasa Indonesia 87
         * ============================================================
         */
        foreach ($lines as $index => $line) {
            $normalizedLine = strtolower($line);

            if (!str_contains($normalizedLine, $subjectKey)) {
                continue;
            }

            // Ambil angka setelah nama mapel
            $afterSubject = substr(
                $line,
                stripos($line, $subject)
            );

            $grade = $this->findGradeInText($afterSubject);

            if ($grade !== null) {
                $foundGrade = $grade;
                break;
            }
        }

        /*
         * ============================================================
         * 2. KALAU TIDAK KETEMU, CARI DI SEKITAR POSISI MAPEL
         *
         * Karena OCR tabel sering jadi seperti:
         *
         * Matematika
         * 85
         *
         * atau:
         *
         * Matematika
         * Keterangan
         * 85
         *
         * ============================================================
         */
        if ($foundGrade === null) {
            foreach ($lines as $index => $line) {
                if (!str_contains(strtolower($line), $subjectKey)) {
                    continue;
                }

                // Cari sampai 8 baris setelah nama mapel
                for ($offset = 1; $offset <= 8; $offset++) {
                    $nextIndex = $index + $offset;

                    if (!isset($lines[$nextIndex])) {
                        break;
                    }

                    $candidate = $lines[$nextIndex];

                    // Jangan masuk ke mapel lain
                    if ($this->containsAnotherSubject($candidate, $subjects, $subject)) {
                        break;
                    }

                    $grade = $this->findGradeInText($candidate);

                    if ($grade !== null) {
                        $foundGrade = $grade;
                        break 2;
                    }
                }
            }
        }

        /*
         * ============================================================
         * 3. KALAU MASIH TIDAK KETEMU, CARI SEBELUM MAPEL
         *
         * Beberapa layout tabel ketika di-OCR bisa membuat:
         *
         * 85
         * Matematika
         *
         * ============================================================
         */
        if ($foundGrade === null) {
            foreach ($lines as $index => $line) {
                if (!str_contains(strtolower($line), $subjectKey)) {
                    continue;
                }

                for ($offset = 1; $offset <= 5; $offset++) {
                    $prevIndex = $index - $offset;

                    if ($prevIndex < 0) {
                        break;
                    }

                    $candidate = $lines[$prevIndex];

                    if ($this->containsAnotherSubject($candidate, $subjects, $subject)) {
                        break;
                    }

                    $grade = $this->findGradeInText($candidate);

                    if ($grade !== null) {
                        $foundGrade = $grade;
                        break 2;
                    }
                }
            }
        }

        if ($foundGrade !== null) {
            $grades[$subject] = $foundGrade;
        }
    }

    return $grades;
}
    
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

private function findGradeInText(string $text): ?float
{
    preg_match_all(
        '/(?<!\d)(\d{1,3})(?:[,.](\d{1,2}))?(?!\d)/',
        $text,
        $matches,
        PREG_SET_ORDER
    );

    foreach ($matches as $match) {
        $value = (float) ($match[1] . (isset($match[2]) ? '.' . $match[2] : ''));

        // Nilai rapor yang kita cari
        if ($value >= 60 && $value <= 100) {
            return $value;
        }
    }

    return null;
} 

private function containsAnotherSubject(
    string $line,
    array $subjects,
    string $currentSubject
): bool {
    $line = strtolower($line);

    foreach ($subjects as $subject) {
        if ($subject === $currentSubject) {
            continue;
        }

        if (str_contains($line, strtolower($subject))) {
            return true;
        }
    }

    return false;
}
