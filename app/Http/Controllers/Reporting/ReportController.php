<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Models\PPDB\Registration;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;
use App\Models\PpdbPeriod;

class ReportController extends Controller
{
    // Laporan pendaftar PPDB
    public function ppdbIndex(Request $request)
    {
        $registrations = $this->filteredRegistrations($request)
            ->paginate(20)
            ->withQueryString();

        $periods = PpdbPeriod::orderByDesc('name')->get();

        return view('reporting.ppdb', compact(
            'registrations',
            'periods'
        ));
    }

    public function ppdbPdf(Request $request)
    {
        $registrations = $this->filteredRegistrations($request)->get();

        $pdf = Pdf::loadView(
            'reporting.exports.ppdb-pdf',
            compact('registrations')
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-ppdb-' . now()->format('Ymd-His') . '.pdf'
        );
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
            'period',
        ])
            ->when($request->period_id, function ($q) use ($request) {
                $q->where('period_id', $request->period_id);
            })
            ->when($request->from, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from);
            })
            ->when($request->to, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to);
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->school_origin, function ($q) use ($request) {
                $q->whereHas('biodata', function ($bio) use ($request) {
                    $bio->where(
                        'school_origin',
                        'like',
                        "%{$request->school_origin}%"
                    );
                });
            })
            ->latest();
    }
 
}