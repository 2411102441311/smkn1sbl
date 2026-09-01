<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Models\PPDB\Registration;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;

class ReportController extends Controller
{
    // Laporan pendaftar PPDB dalam rentang tanggal
    public function ppdbIndex(Request $request)
    {
        $registrations = $this->filteredRegistrations($request)->paginate(20);
        return view('reporting.ppdb', compact('registrations'));
    }

    public function ppdbPdf(Request $request)
    {
        $registrations = $this->filteredRegistrations($request)->get();

        $pdf = Pdf::loadView('reporting.exports.ppdb-pdf', compact('registrations'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-ppdb-' . now()->format('Ymd-His') . '.pdf');
    }

    public function ppdbExcel(Request $request)
    {
        $registrations = $this->filteredRegistrations($request)->get();

        return Excel::download(
            new RegistrationsExport($registrations),
            'laporan-ppdb-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    protected function filteredRegistrations(Request $request)
    {
        return Registration::with([
                'biodata',
                'parentData',
                'majorChoices.major',
                'sawResult.recommendedMajor',
            ])
            ->when($request->from, fn ($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to, fn ($q) => $q->whereDate('created_at', '<=', $request->to))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->school_origin, function ($q) use ($request) {
                $q->whereHas('biodata', fn ($bio) => $bio->where('school_origin', 'like', "%{$request->school_origin}%"));
            })
            ->latest();
    }
}