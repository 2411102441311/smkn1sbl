<?php

namespace App\Http\Controllers;

use App\Models\CMS\News;
use App\Models\CMS\Announcement;
use App\Models\CMS\Gallery;
use App\Models\ThemeManager\Theme;
use App\Models\ThemeManager\Banner;
use App\Models\CMS\Setting;

class HomeController extends Controller
{
    // Halaman depan publik: wallpaper foto sekolah, tema biru muda, bingkai mengambang
    public function index()
    {
        $theme = Theme::active();
        $banners = Banner::active()->get();
        $latestNews = News::published()->take(3)->get();
        $announcements = Announcement::active()->take(5)->get();
        $galleries = Gallery::latest()->take(8)->get();
        $schoolName = Setting::get('school_name', 'SMK Negeri 1 Sebulu');

        // Data jurusan diambil dari MajorController::data() — SUMBER TUNGGAL,
        // supaya selalu konsisten dengan halaman detail jurusan (/jurusan/{slug}).
        // Kalau mau tambah/ubah jurusan, edit di MajorController::data(), bukan di sini.
        $majors = MajorController::data();

        // Data kepala sekolah untuk section sambutan — sementara statis, bisa dipindah ke Setting/tabel tersendiri nanti
        $principal = [
            'name' => Setting::get('principal_name', 'Nama Kepala Sekolah, S.Pd., M.Pd.'),
            'photo' => Setting::get('principal_photo'), // null jika belum diisi, fallback ke public/images/kepala-sekolah.jpg
        ];

        return view('welcome', compact(
            'theme', 'banners', 'latestNews', 'announcements', 'galleries', 'majors', 'principal', 'schoolName'
        ));
    }
}