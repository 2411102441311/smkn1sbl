<?php

namespace App\Http\Controllers\SPK;

use App\Http\Controllers\Controller;
use App\Models\SPK\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::latest()->get();
        return view('spk.criteria.index', compact('criteria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|unique:spk_criteria,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
        ]);

        Criteria::create($data);

        return back()->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, Criteria $criterion)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|unique:spk_criteria,code,' . $criterion->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
        ]);

        $criterion->update($data);

        return back()->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Criteria $criterion)
    {
        $criterion->delete();
        return back()->with('success', 'Kriteria berhasil dihapus.');
    }
}
