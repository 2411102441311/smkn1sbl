<?php

namespace App\Http\Controllers;

use App\Models\CMS\Setting;

class SchoolProfileController extends Controller
{
    // Halaman Profil Sekolah: Sejarah, Visi Misi, Struktur Organisasi, Guru, Prestasi, Ekstrakurikuler
    public function index()
    {
        $schoolName = Setting::get('school_name', 'SMK Negeri 1 Sebulu');

        // Data di bawah ini sementara statis — nanti bisa dipindah ke tabel/Settings tersendiri
        // kalau kakak mau bisa diedit lewat halaman admin.
        $history = [
            'founded_year' => '1999',
            'sk_number' => 'SK Pendirian Nomor 421.5/123/DISDIK/1999',
            'text' => "Didirikan pada tahun 1999, sekolah ini bermula dari kebutuhan masyarakat Sebulu akan pendidikan kejuruan yang berkualitas. Sejak awal berdirinya, sekolah berkomitmen menyelenggarakan pendidikan yang memadukan penguasaan ilmu pengetahuan, keterampilan teknis, dan pembentukan karakter bagi peserta didik.\n\nSeiring berjalannya waktu, sekolah terus berkembang — baik dari sisi jumlah program keahlian, fasilitas praktik, maupun kerja sama dengan dunia usaha dan industri (DUDI) — hingga menjadi salah satu sekolah menengah kejuruan rujukan di Kutai Kartanegara.",
        ];

        $vision = 'Menjadi lembaga pendidikan kejuruan unggul yang menghasilkan lulusan kompeten, berkarakter, dan siap bersaing di dunia kerja maupun industri.';

        $missions = [
            'Menyelenggarakan pembelajaran berbasis kompetensi yang relevan dengan kebutuhan dunia usaha dan industri.',
            'Membentuk karakter peserta didik yang jujur, disiplin, dan bertanggung jawab.',
            'Mengembangkan kerja sama dengan dunia usaha, industri, dan perguruan tinggi.',
            'Meningkatkan kompetensi tenaga pendidik dan kependidikan secara berkelanjutan.',
            'Menyediakan sarana dan prasarana praktik yang sesuai standar industri.',
        ];

        $orgStructure = [
            ['role' => 'Kepala Sekolah', 'level' => 1],
            ['role' => 'Wakil Kepala Sekolah Kurikulum', 'level' => 2],
            ['role' => 'Wakil Kepala Sekolah Kesiswaan', 'level' => 2],
            ['role' => 'Wakil Kepala Sekolah Sarana & Prasarana', 'level' => 2],
            ['role' => 'Wakil Kepala Sekolah Humas & DUDI', 'level' => 2],
            ['role' => 'Kepala Program Keahlian', 'level' => 3],
            ['role' => 'Guru & Tenaga Kependidikan', 'level' => 4],
        ];

        $teachers = [
            ['name' => 'Nama Guru 1, S.Pd.', 'subject' => 'Matematika'],
            ['name' => 'Nama Guru 2, S.Kom.', 'subject' => 'Pemrograman Web (RPL)'],
            ['name' => 'Nama Guru 3, S.Pd.', 'subject' => 'Bahasa Indonesia'],
            ['name' => 'Nama Guru 4, S.T.', 'subject' => 'Jaringan Komputer (TKJ)'],
            ['name' => 'Nama Guru 5, S.Pd.', 'subject' => 'Bahasa Inggris'],
            ['name' => 'Nama Guru 6, S.Pd.', 'subject' => 'Teknik Kendaraan Ringan'],
            ['name' => 'Nama Guru 7, S.E.', 'subject' => 'Akuntansi'],
            ['name' => 'Nama Guru 8, S.Sn.', 'subject' => 'Desain Komunikasi Visual'],
        ];

        $achievements = [
            ['year' => '2025', 'title' => 'Juara 1 LKS Tingkat Provinsi', 'category' => 'Kompetensi Jaringan Komputer'],
            ['year' => '2025', 'title' => 'Juara 2 Lomba Debat Bahasa Inggris', 'category' => 'Tingkat Kabupaten'],
            ['year' => '2024', 'title' => 'Akreditasi "A" Unggul', 'category' => 'BAN-SM'],
            ['year' => '2024', 'title' => 'Juara 3 Desain Poster Digital', 'category' => 'Tingkat Provinsi'],
        ];

        $extracurriculars = [
            ['name' => 'Pramuka', 'icon' => 'flag'],
            ['name' => 'OSIS', 'icon' => 'users'],
            ['name' => 'Futsal', 'icon' => 'circle'],
            ['name' => 'Basket', 'icon' => 'circle'],
            ['name' => 'Paskibra', 'icon' => 'flag'],
            ['name' => 'Rohis', 'icon' => 'book'],
            ['name' => 'PMR', 'icon' => 'heart'],
            ['name' => 'Robotik', 'icon' => 'cpu'],
        ];

        return view('profil', compact(
            'schoolName', 'history', 'vision', 'missions',
            'orgStructure', 'teachers', 'achievements', 'extracurriculars'
        ));
    }
}