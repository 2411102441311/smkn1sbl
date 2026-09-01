<?php

namespace App\Services;

use App\Models\Major;
use App\Models\PPDB\Registration;
use App\Models\PPDB\SawResult;

/**
 * Engine SAW (Simple Additive Weighting) untuk merekomendasikan jurusan.
 *
 * Ada 2 cara pakai:
 * - calculateFromGrades()  → dipakai di WIZARD PENDAFTARAN, sebelum ada record Registration
 *   (dihitung dari nilai yang sudah dikonfirmasi siswa di session, sebelum submit final).
 * - calculate()            → dipakai untuk hitung ulang & SIMPAN hasil SAW ke database,
 *   dipanggil saat submit final wizard (atau re-hitung manual oleh admin nanti).
 */
class SawService
{
    protected array $weightProfiles = [
        'tkj' => [
            'Matematika' => 0.35,
            'IPA' => 0.30,
            'Bahasa Inggris' => 0.20,
            'Bahasa Indonesia' => 0.15,
        ],
        'mp' => [
            'Bahasa Indonesia' => 0.30,
            'IPS' => 0.30,
            'Bahasa Inggris' => 0.25,
            'Matematika' => 0.15,
        ],
        'atp' => [
            'IPA' => 0.40,
            'Matematika' => 0.20,
            'Bahasa Indonesia' => 0.20,
            'IPS' => 0.20,
        ],
    ];

    protected float $maxGrade = 100.0;

    /**
     * Dipakai di wizard: hitung skor SAW langsung dari array nilai (belum ada Registration).
     * Return: ['scores' => ['tkj' => 0.82, 'mp' => 0.65, ...], 'recommended_slug' => 'tkj']
     */
    public function calculateFromGrades(array $grades): array
    {
        $scoresByMajorSlug = [];

        foreach ($this->weightProfiles as $majorSlug => $weights) {
            $score = 0;
            foreach ($weights as $subject => $weight) {
                $rawGrade = $grades[$subject] ?? 0;
                $normalized = min($rawGrade / $this->maxGrade, 1);
                $score += $normalized * $weight;
            }
            $scoresByMajorSlug[$majorSlug] = round($score, 4);
        }

        arsort($scoresByMajorSlug);

        return [
            'scores' => $scoresByMajorSlug,
            'recommended_slug' => array_key_first($scoresByMajorSlug),
        ];
    }

    /**
     * Dipakai saat submit final wizard: simpan hasil perhitungan SAW ke database,
     * terhubung ke Registration yang baru saja dibuat.
     */
    public function saveResult(Registration $registration, array $grades): ?SawResult
    {
        $calculated = $this->calculateFromGrades($grades);

        if (empty($grades)) {
            return null;
        }

        $bestMajor = Major::where('slug', $calculated['recommended_slug'])->first();

        return SawResult::create([
            'registration_id' => $registration->id,
            'criteria_scores' => $calculated['scores'],
            'total_score' => $calculated['scores'][$calculated['recommended_slug']],
            'recommended_major_id' => $bestMajor?->id,
        ]);
    }

    /**
     * Dipakai untuk hitung ULANG (bukan wizard) — misal admin klik "Hitung Ulang SAW"
     * pada pendaftaran yang sudah ada di database.
     */
    public function calculate(Registration $registration): ?SawResult
    {
        $reportCard = $registration->reportCards()
            ->whereHas('ocrResult', fn ($q) => $q->where('is_confirmed', true))
            ->latest('uploaded_at')
            ->first();

        $grades = $reportCard?->ocrResult?->extracted_data ?? [];

        return $this->saveResult($registration, $grades);
    }
}