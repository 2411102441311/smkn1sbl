<?php

namespace App\Http\Controllers\ThemeManager;

use App\Http\Controllers\Controller;
use App\Models\ThemeManager\Theme;
use App\Models\ThemeManager\ThemeSchedule;
use Illuminate\Http\Request;

class ThemeScheduleController extends Controller
{
    public function index()
    {
        $schedules = ThemeSchedule::with('theme')->orderBy('start_at')->paginate(15);
        return view('theme.schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after:start_at',
        ]);

        ThemeSchedule::create($data);

        return back()->with('success', 'Jadwal tema berhasil dibuat.');
    }

    public function destroy(ThemeSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal tema berhasil dihapus.');
    }

    /**
     * Dipanggil scheduler (Kernel) tiap menit: mengaktifkan tema sesuai jadwal berjalan.
     */
    public function applyDueSchedules(): void
    {
        $due = ThemeSchedule::where('start_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', now());
            })
            ->latest('start_at')
            ->first();

        if ($due) {
            $due->theme->activate();
        }
    }
}
