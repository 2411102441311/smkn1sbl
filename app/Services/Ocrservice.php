<?php

namespace App\Services;

use App\Models\PPDB\OcrResult;
use App\Models\PPDB\ReportCard;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrService
{
    /**
     * Nilai inti yang digunakan oleh SPK/SAW.
     */
    protected array $subjects = [
        'Matematika',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'IPA',
        'IPS',
    ];

    /**
     * Ekstrak OCR dari satu file.
     *
     * Mendukung:
     * - Rapor tabel
     * - SKL
     */
    public function extractFromPath(string $absoluteImagePath): array
    {
        if (!is_file($absoluteImagePath)) {
            \Log::error('File OCR tidak ditemukan', [
                'image' => $absoluteImagePath,
            ]);

            return [
                'raw_text' => '',
                'grades' => [],
                'confidence' => 0,
            ];
        }

        $ocrImagePath = $this->prepareImageForOcr($absoluteImagePath);

        /*
         * PSM 4:
         * Cocok untuk tabel rapor.
         *
         * PSM 11:
         * Cocok untuk SKL/dokumen yang teksnya tersebar.
         */
        $textPsm4 = $this->extractText(
            $ocrImagePath,
            4
        );

        $textPsm11 = $this->extractText(
            $ocrImagePath,
            11
        );

        if ($ocrImagePath !== $absoluteImagePath && is_file($ocrImagePath)) {
            @unlink($ocrImagePath);
        }

        /*
         * Parse PSM 4 terlebih dahulu.
         */
        $grades = $this->parseGrades(
            $textPsm4,
            true
        );

        /*
         * PSM 11 hanya digunakan untuk melengkapi
         * nilai yang belum ditemukan.
         */
        $gradesPsm11 = $this->parseGrades(
            $textPsm11,
            false
        );

        foreach ($gradesPsm11 as $subject => $value) {
            if (!isset($grades[$subject])) {
                $grades[$subject] = $value;
            }
        }

        /*
         * Bentuk IPA dan IPS.
         */
        $grades = $this->buildDerivedGrades(
            $grades
        );

        /*
         * Confidence berdasarkan 5 nilai inti.
         */
        $confidence = $this->calculateConfidence(
            $grades
        );

        $rawText = trim(
            "===== OCR PSM 4 =====\n" .
            $textPsm4 .
            "\n\n===== OCR PSM 11 =====\n" .
            $textPsm11
        );

        return [
            'raw_text' => $rawText,
            'grades' => $grades,
            'confidence' => $confidence,
        ];
    }

    /**
     * Menyamakan orientasi dan ukuran foto kamera HP sebelum OCR.
     */
    protected function prepareImageForOcr(string $imagePath): string
    {
        if (!function_exists('imagecreatefromjpeg')) {
            return $imagePath;
        }

        $imageInfo = @getimagesize($imagePath);
        if (!$imageInfo) {
            return $imagePath;
        }

        $source = match ($imageInfo['mime'] ?? '') {
            'image/jpeg' => @imagecreatefromjpeg($imagePath),
            'image/png' => function_exists('imagecreatefrompng') ? @imagecreatefrompng($imagePath) : false,
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($imagePath) : false,
            default => false,
        };

        if (!$source) {
            return $imagePath;
        }

        $width = imagesx($source);
        $height = imagesy($source);

        if ($imageInfo['mime'] === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($imagePath);
            $orientation = (int) ($exif['Orientation'] ?? 1);

            $source = match ($orientation) {
                3 => imagerotate($source, 180, 0),
                6 => imagerotate($source, -90, 0),
                8 => imagerotate($source, 90, 0),
                default => $source,
            } ?: $source;

            $width = imagesx($source);
            $height = imagesy($source);
        }

        $maxDimension = 2200;
        $scale = min(1, $maxDimension / max($width, $height));
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));
        $target = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $normalizedPath = storage_path('app/ocr-' . uniqid('', true) . '.jpg');
        imagejpeg($target, $normalizedPath, 88);
        imagedestroy($target);
        imagedestroy($source);

        return is_file($normalizedPath) ? $normalizedPath : $imagePath;
    }

    /**
     * Ekstrak beberapa foto.
     *
     * Nilai dari semua foto digabung dan dirata-ratakan
     * berdasarkan mata pelajaran.
     */
    public function extractFromPaths(
        array $absoluteImagePaths
    ): array {
        $allTexts = [];
        $gradesPerSubject = [];

        foreach ($absoluteImagePaths as $path) {

            if (!is_file($path)) {
                continue;
            }

            $result = $this->extractFromPath($path);

            if ($result['raw_text'] !== '') {
                $allTexts[] = $result['raw_text'];
            }

            foreach ($result['grades'] as $subject => $value) {
                $gradesPerSubject[$subject][] = $value;
            }
        }

        /*
         * Rata-rata nilai yang muncul pada beberapa foto.
         */
        $grades = [];

        foreach ($gradesPerSubject as $subject => $values) {

            if (empty($values)) {
                continue;
            }

            $grades[$subject] = round(
                array_sum($values) / count($values),
                2
            );
        }

        $confidence = $this->calculateConfidence(
            $grades
        );

        return [
            'raw_text' => implode(
                "\n\n",
                $allTexts
            ),
            'grades' => $grades,
            'confidence' => $confidence,
        ];
    }

    /**
     * Simpan hasil OCR ke database.
     */
    public function process(
        ReportCard $reportCard
    ): OcrResult {
        $imagePath = storage_path(
            'app/public/' . $reportCard->file_path
        );

        $result = $this->extractFromPath(
            $imagePath
        );

        return OcrResult::updateOrCreate(
            [
                'report_card_id' => $reportCard->id,
            ],
            [
                'raw_text' => $result['raw_text'],
                'extracted_data' => $result['grades'],
                'confidence_score' => $result['confidence'],
                'is_confirmed' => false,
            ]
        );
    }

    /**
     * Menjalankan Tesseract.
     */
    protected function extractText(
        string $imagePath,
        int $psm = 4
    ): string {
        try {

            $tesseractPath = env(
                'TESSERACT_PATH',
                'C:\\Program Files\\Tesseract-OCR\\tesseract.exe'
            );

            $tessdataPath = env(
                'TESSDATA_PATH',
                'C:\\Program Files\\Tesseract-OCR\\tessdata'
            );

            $tesseract = new TesseractOCR(
                $imagePath
            );

            $tesseract
                ->executable($tesseractPath)
                ->tessdataDir($tessdataPath)
                ->lang('ind', 'eng')
                ->psm($psm);

            $result = $tesseract->run();

            \Log::info(
                'OCR berhasil dijalankan',
                [
                    'image' => $imagePath,
                    'psm' => $psm,
                    'text_length' => strlen($result),
                ]
            );

            return $result;

        } catch (\Throwable $e) {

            \Log::error(
                'OCR gagal dijalankan',
                [
                    'image' => $imagePath,
                    'psm' => $psm,
                    'error' => $e->getMessage(),
                ]
            );

            report($e);

            return '';
        }
    }

    /**
     * Parse nilai dari OCR.
     */
    protected function parseGrades(
        string $text,
        bool $isRapor = true
    ): array {
        $results = [];

        if (trim($text) === '') {
            return $results;
        }

        $lines = preg_split(
            '/\r\n|\r|\n/',
            $text
        );

        if (!$lines) {
            return $results;
        }

        /*
         * Daftar mapel yang dicari.
         */
        $subjects = [
            'Bahasa Indonesia' => [
                'Bahasa Indonesia',
                'Bahasa indonesia',
            ],

            'Bahasa Inggris' => [
                'Bahasa Inggris',
            ],

            'Matematika' => [
                'Matematika',
            ],

            '_Fisika' => [
                'Fisika',
                'Fisike',
            ],

            '_Kimia' => [
                'Kimia',
            ],

            '_Sejarah' => [
                'Sejarah Indonesia',
                'Sejarah',
            ],
        ];

        foreach ($subjects as $subject => $patterns) {

            /*
             * Cari kemunculan nama mapel.
             */
            foreach ($lines as $index => $line) {

                $line = trim($line);

                if ($line === '') {
                    continue;
                }

                $matchedPattern = null;

                foreach ($patterns as $pattern) {

                    if (
                        stripos(
                            $line,
                            $pattern
                        ) !== false
                    ) {
                        $matchedPattern = $pattern;
                        break;
                    }
                }

                if ($matchedPattern === null) {
                    continue;
                }

                /*
                 * Ambil angka dari baris yang sama
                 * setelah nama mapel.
                 */
                $position = stripos(
                    $line,
                    $matchedPattern
                );

                $afterSubject = substr(
                    $line,
                    $position +
                    strlen($matchedPattern)
                );

                $numbers = $this->extractNumbers(
                    $afterSubject
                );

                /*
                 * Kalau belum cukup, cari angka
                 * pada beberapa baris berikutnya.
                 */
                for (
                    $offset = 1;
                    $offset <= 8;
                    $offset++
                ) {

                    if (
                        !isset(
                            $lines[
                                $index + $offset
                            ]
                        )
                    ) {
                        break;
                    }

                    $nextLine = trim(
                        $lines[
                            $index + $offset
                        ]
                    );

                    if ($nextLine === '') {
                        continue;
                    }

                    /*
                     * Kalau ketemu mapel lain,
                     * jangan mengambil nilai mapel tersebut.
                     */
                    if (
                        $this->isAnotherSubject(
                            $nextLine,
                            $subject
                        )
                    ) {
                        break;
                    }

                    $lineNumbers =
                        $this->extractNumbers(
                            $nextLine
                        );

                    foreach (
                        $lineNumbers
                        as $number
                    ) {
                        $numbers[] = $number;
                    }

                    /*
                     * Untuk rapor:
                     * cukup 3 angka:
                     *
                     * Pengetahuan
                     * Keterampilan
                     * Nilai Akhir
                     */
                    if (
                        count($numbers) >= 3
                    ) {
                        break;
                    }

                    /*
                     * Untuk SKL cukup 1 nilai.
                     */
                    if (
                        !$isRapor &&
                        count($numbers) >= 1
                    ) {
                        break;
                    }
                }

                /*
                 * Hilangkan angka duplikat berurutan.
                 */
                $numbers = $this->cleanNumbers(
                    $numbers
                );

                if (empty($numbers)) {
                    continue;
                }

                /*
                 * =====================================================
                 * FORMAT RAPOR
                 * =====================================================
                 *
                 * Contoh:
                 *
                 * Bahasa Indonesia
                 * 73
                 * 81
                 * 77
                 *
                 * Ambil angka terakhir dari tiga nilai.
                 */
                if (
                    $isRapor &&
                    count($numbers) >= 3
                ) {

                    $lastThree = array_slice(
                        $numbers,
                        -3
                    );

                    $knowledge =
                        $lastThree[0];

                    $skill =
                        $lastThree[1];

                    $final =
                        $lastThree[2];

                    /*
                     * Jika nilai akhir valid,
                     * gunakan langsung.
                     */
                    if (
                        $final >= 60 &&
                        $final <= 100
                    ) {
                        $results[$subject] =
                            $final;

                        break;
                    }

                    /*
                     * Kalau OCR salah membaca nilai akhir
                     * menjadi angka seperti "7",
                     * gunakan rata-rata pengetahuan
                     * dan keterampilan.
                     */
                    if (
                        $knowledge >= 60 &&
                        $knowledge <= 100 &&
                        $skill >= 60 &&
                        $skill <= 100
                    ) {
                        $results[$subject] =
                            round(
                                (
                                    $knowledge +
                                    $skill
                                ) / 2,
                                2
                            );

                        break;
                    }
                }

                /*
                 * =====================================================
                 * FORMAT SKL
                 * =====================================================
                 *
                 * Contoh:
                 *
                 * Bahasa Indonesia
                 * 87,00
                 */
                if (
                    !$isRapor &&
                    !empty($numbers)
                ) {

                    /*
                     * Nilai terakhir biasanya
                     * merupakan nilai mapel.
                     */
                    $validNumbers = array_filter(
                        $numbers,
                        function ($number) {
                            return
                                $number >= 60 &&
                                $number <= 100;
                        }
                    );

                    if (
                        !empty($validNumbers)
                    ) {
                        $results[$subject] =
                            (float) end(
                                $validNumbers
                            );

                        break;
                    }
                }

                /*
                 * Fallback untuk rapor jika
                 * OCR hanya mendapatkan satu nilai.
                 */
                if (
                    $isRapor &&
                    count($numbers) === 1
                ) {

                    if (
                        $numbers[0] >= 60 &&
                        $numbers[0] <= 100
                    ) {
                        $results[$subject] =
                            $numbers[0];

                        break;
                    }
                }
            }
        }

        return $results;
    }

    /**
     * Ambil angka dari teks.
     */
    protected function extractNumbers(
        string $text
    ): array {
        preg_match_all(
            '/(?<!\d)(\d{1,3}(?:[,.]\d{1,2})?)(?!\d)/',
            $text,
            $matches
        );

        $numbers = [];

        foreach (
            $matches[1] ?? []
            as $number
        ) {

            $number = str_replace(
                ',',
                '.',
                $number
            );

            $number = (float) $number;

            /*
             * Nilai rapor/SKL.
             */
            if (
                $number >= 0 &&
                $number <= 100
            ) {
                $numbers[] = $number;
            }
        }

        return $numbers;
    }

    /**
     * Bersihkan angka yang duplikat.
     */
    protected function cleanNumbers(
        array $numbers
    ): array {
        $clean = [];

        foreach ($numbers as $number) {

            if (
                empty($clean) ||
                end($clean) !== $number
            ) {
                $clean[] = $number;
            }
        }

        return $clean;
    }

    /**
     * Cek apakah baris mengandung
     * mata pelajaran lain.
     */
    protected function isAnotherSubject(
        string $line,
        string $currentSubject
    ): bool {
        $patterns = [
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Matematika',
            'Fisika',
            'Fisike',
            'Kimia',
            'Sejarah Indonesia',
        ];

        foreach ($patterns as $pattern) {

            if (
                $pattern === $currentSubject
            ) {
                continue;
            }

            if (
                stripos(
                    $line,
                    $pattern
                ) !== false
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Bentuk nilai IPA dan IPS.
     *
     * IPA:
     * Fisika + Kimia / 2
     *
     * IPS:
     * Sejarah Indonesia
     */
    protected function buildDerivedGrades(
        array $grades
    ): array {

        $fisika =
            $grades['_Fisika'] ?? null;

        $kimia =
            $grades['_Kimia'] ?? null;

        $sejarah =
            $grades['_Sejarah'] ?? null;

        /*
         * IPA.
         */
        if (
            $fisika !== null &&
            $kimia !== null
        ) {

            $grades['IPA'] =
                round(
                    (
                        $fisika +
                        $kimia
                    ) / 2,
                    2
                );

        } elseif ($fisika !== null) {

            $grades['IPA'] =
                $fisika;

        } elseif ($kimia !== null) {

            $grades['IPA'] =
                $kimia;
        }

        /*
         * IPS.
         */
        if ($sejarah !== null) {

            $grades['IPS'] =
                $sejarah;
        }

        /*
         * Hapus nilai internal.
         */
        unset(
            $grades['_Fisika'],
            $grades['_Kimia'],
            $grades['_Sejarah']
        );

        /*
         * Hanya kirim 5 nilai inti.
         */
        return array_intersect_key(
            $grades,
            array_flip(
                $this->subjects
            )
        );
    }

    /**
     * Hitung confidence.
     *
     * 5 mapel = 100%
     */
    protected function calculateConfidence(
        array $grades
    ): float {

        $found = 0;

        foreach (
            $this->subjects
            as $subject
        ) {

            if (
                isset($grades[$subject]) &&
                $grades[$subject] !== null
            ) {
                $found++;
            }
        }

        return round(
            (
                $found /
                count($this->subjects)
            ) * 100,
            2
        );
    }

    /**
     * Daftar mapel untuk halaman konfirmasi.
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }
}