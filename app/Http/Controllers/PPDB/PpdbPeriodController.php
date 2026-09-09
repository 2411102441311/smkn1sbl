<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\PpdbPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbPeriodController extends Controller
{
    public function index()
    {
        $periods = PpdbPeriod::orderByDesc('start_date')->get();

        return view('ppdb.periods.index', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        PpdbPeriod::create([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => false,
        ]);

        return redirect()
            ->route('admin.ppdb.periods.index')
            ->with('success', 'Periode PPDB berhasil ditambahkan.');
    }

    public function update(Request $request, PpdbPeriod $period)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $isActive = $request->boolean('is_active');

        DB::transaction(function () use ($period, $validated, $isActive) {

            if ($isActive) {
                PpdbPeriod::where('id', '!=', $period->id)
                    ->update(['is_active' => false]);
            }

            $period->update([
                'name' => $validated['name'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_active' => $isActive,
            ]);
        });

        return redirect()
            ->route('admin.ppdb.periods.index')
            ->with('success', 'Periode PPDB berhasil diperbarui.');
    }

    public function destroy(PpdbPeriod $period)
    {
        if ($period->registrations()->exists()) {
            return redirect()
                ->route('admin.ppdb.periods.index')
                ->with('error', 'Periode tidak dapat dihapus karena sudah memiliki data pendaftar.');
        }

        $period->delete();

        return redirect()
            ->route('admin.ppdb.periods.index')
            ->with('success', 'Periode PPDB berhasil dihapus.');
    }
}