<?php

namespace App\Http\Controllers\SPK;

use App\Http\Controllers\Controller;
use App\Models\SPK\Alternative;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with('evaluations.criteria')->latest()->get();
        return view('spk.alternatives.index', compact('alternatives'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|unique:spk_alternatives,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Alternative::create($data);

        return back()->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return back()->with('success', 'Alternatif berhasil dihapus.');
    }
}
