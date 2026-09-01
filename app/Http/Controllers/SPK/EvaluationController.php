<?php

namespace App\Http\Controllers\SPK;

use App\Http\Controllers\Controller;
use App\Models\SPK\Evaluation;
use App\Models\SPK\Alternative;
use App\Models\SPK\Criteria;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    // Matriks penilaian alternatif x kriteria
    public function index()
    {
        $alternatives = Alternative::all();
        $criteria = Criteria::all();
        $evaluations = Evaluation::all()->groupBy('alternative_id');

        return view('spk.evaluations.index', compact('alternatives', 'criteria', 'evaluations'));
    }

    // Simpan matriks nilai sekaligus (form tabel)
    public function store(Request $request)
    {
        $data = $request->validate([
            'values' => 'required|array', // values[alternative_id][criteria_id] = nilai
        ]);

        foreach ($data['values'] as $alternativeId => $criteriaValues) {
            foreach ($criteriaValues as $criteriaId => $value) {
                if ($value === null || $value === '') {
                    continue;
                }
                Evaluation::updateOrCreate(
                    ['alternative_id' => $alternativeId, 'criteria_id' => $criteriaId],
                    ['value' => $value]
                );
            }
        }

        return back()->with('success', 'Matriks penilaian berhasil disimpan.');
    }
}
