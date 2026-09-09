<?php

namespace App\Http\Controllers;

use App\Models\CMS\News;
use App\Models\CMS\Announcement;
use App\Models\CMS\Gallery;
use App\Models\ThemeManager\Theme;
use App\Models\ThemeManager\Banner;
use App\Models\CMS\Setting;
use App\Models\PpdbPeriod;
use Carbon\Carbon;

class HomeController extends Controller
{
    // Halaman depan publik
    public function index()
    {
        $theme = Theme::active();
        $banners = Banner::active()->get();
        $latestNews = News::published()->take(3)->get();

        // Pengumuman manual dari database
        $announcements = Announcement::active()->take(5)->get();

        /*
         * =========================================================
         * INFORMASI PPDB OTOMATIS
         * =========================================================
         *
         * Mengambil periode PPDB dari tabel ppdb_periods.
         * Tidak perlu membuat pengumuman manual untuk PPDB.
         */
        $today = Carbon::today();

        $ppdbPeriod = PpdbPeriod::where('is_active', true)
            ->where(function ($query) use ($today) {
                $query->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->orderByDesc('start_date')
            ->first();

        /*
         * Cari periode berikutnya jika belum ada periode yang sedang
         * berlangsung.
         */
        $ppdbUpcomingPeriod = PpdbPeriod::where('is_active', true)
            ->whereDate('start_date', '>', $today)
            ->orderBy('start_date')
            ->first();

        /*
         * Cari periode aktif yang sudah berakhir.
         */
        $ppdbEndedPeriod = PpdbPeriod::where('is_active', true)
            ->whereDate('end_date', '<', $today)
            ->orderByDesc('end_date')
            ->first();

        $galleries = Gallery::whereNull('major_slug')
            ->whereDoesntHave('category', function ($query) {
                $query->where('name', 'Fasilitas');
            })
            ->latest()
            ->take(8)
            ->get();

        $schoolName = Setting::get(
            'school_name',
            'SMK Negeri 1 Sebulu'
        );

        // Data jurusan diambil dari MajorController::data()
        $majors = MajorController::data();

        // Data kepala sekolah
        $principal = [
            'name' => Setting::get(
                'principal_name',
                'Nama Kepala Sekolah, S.Pd., M.Pd.'
            ),
            'photo' => Setting::get('principal_photo'),
        ];

        return view('welcome', compact(
            'theme',
            'banners',
            'latestNews',
            'announcements',
            'ppdbPeriod',
            'ppdbUpcomingPeriod',
            'ppdbEndedPeriod',
            'galleries',
            'majors',
            'principal',
            'schoolName'
        ));
    }
}