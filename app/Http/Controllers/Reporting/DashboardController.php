<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Models\CMS\News;
use App\Models\CMS\Page;
use App\Models\PPDB\Registration;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_registrations' => Registration::count(),
            'total_registrations_submitted' => Registration::where('status', 'submitted')->count(),
            'total_registrations_accepted' => Registration::where('status', 'accepted')->count(),
            'total_users' => User::count(),
            'total_news' => News::where('status', 'published')->count(),
            'total_pages' => Page::where('status', 'published')->count(),
        ];

        $registrationByStatus = Registration::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status');

        $registrationTrend = Registration::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'registrationByStatus', 'registrationTrend'));
    }
}