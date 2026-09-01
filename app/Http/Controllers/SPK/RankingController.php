<?php

namespace App\Http\Controllers\SPK;

use App\Http\Controllers\Controller;
use App\Models\SPK\Alternative;
use App\Models\SPK\Criteria;
use App\Models\SPK\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = Ranking::with('alternative')
            ->orderBy('rank_position')
            ->get()
            ->groupBy('calculated_at');

        $latest = Ranking::with('alternative')
            ->where('calculated_at', Ranking::max('calculated_at'))
            ->orderBy('rank_position')
            ->get();

        return view('spk.rankings.index', compact('latest'));
    }

    /**
     * Hitung perankingan menggunakan metode SAW (Simple Additive Weighting).
     * 1. Normalisasi matriks: benefit = nilai/max, cost = min/nilai
     * 2. Skor akhir = sum(bobot_kriteria * nilai_normalisasi)
     * 3. Urutkan skor tertinggi ke terendah -> ranking
     */
    public function calculate(Request $request)
    {
        $alternatives = Alternative::with('evaluations')->get();
        $criteria = Criteria::all();

        if ($alternatives->isEmpty() || $criteria->isEmpty()) {
            return back()->with('error', 'Data alternatif/kriteria belum lengkap.');
        }

        // Cari nilai max dan min per kriteria untuk normalisasi
        $maxValues = [];
        $minValues = [];
        foreach ($criteria as $c) {
            $values = $alternatives->flatMap->evaluations
                ->where('criteria_id', $c->id)
                ->pluck('value');

            $maxValues[$c->id] = $values->max() ?: 1;
            $minValues[$c->id] = $values->min() ?: 1;
        }

        $now = now();
        $scores = [];

        foreach ($alternatives as $alt) {
            $score = 0;

            foreach ($criteria as $c) {
                $evaluation = $alt->evaluations->firstWhere('criteria_id', $c->id);
                $value = $evaluation->value ?? 0;

                if ($value == 0) {
                    $normalized = 0;
                } elseif ($c->type === 'benefit') {
                    $normalized = $value / $maxValues[$c->id];
                } else { // cost
                    $normalized = $minValues[$c->id] / $value;
                }

                $score += $normalized * $c->weight;
            }

            $scores[$alt->id] = round($score, 4);
        }

        arsort($scores); // urutkan skor tertinggi -> terendah

        $position = 1;
        foreach ($scores as $alternativeId => $finalScore) {
            Ranking::create([
                'alternative_id' => $alternativeId,
                'final_score' => $finalScore,
                'rank_position' => $position,
                'method' => 'SAW',
                'calculated_at' => $now,
            ]);
            $position++;
        }

        return redirect()->route('spk.rankings.index')->with('success', 'Perankingan SAW berhasil dihitung.');
    }
}
