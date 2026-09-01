<?php

namespace App\Http\Controllers;

use App\Models\CMS\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MajorController extends Controller
{
    /**
     * SUMBER DATA TUNGGAL untuk seluruh jurusan sekolah.
     * Dipakai bareng oleh HomeController (list ringkas di beranda) dan halaman detail di sini.
     * Kalau mau tambah/ubah/hapus jurusan, CUKUP EDIT DI SINI SAJA — otomatis
     * konsisten di semua halaman (beranda, ticker, halaman detail, dst).
     */
    public static function data(): array
    {
        return [
            [
                'slug' => 'tkj',
                'code' => 'TKJ',
                'name' => 'Teknik Komputer & Jaringan',
                'desc' => 'Instalasi jaringan, administrasi server, dan keamanan sistem informasi.',
                'icon' => 'network',
                'logo' => 'images/jurusan/tkj/logo.png',
                'color_from' => 'from-skblue-500',
                'color_to' => 'to-skblue-700',
                'description' => "Program keahlian Teknik Komputer dan Jaringan (TKJ) membekali siswa dengan kemampuan merancang, membangun, dan mengelola infrastruktur jaringan komputer — mulai dari jaringan lokal (LAN) hingga jaringan berskala luas (WAN).\n\nSiswa dilatih langsung menggunakan perangkat jaringan standar industri seperti router dan switch, serta mempelajari dasar-dasar keamanan siber, administrasi server, dan troubleshooting jaringan.",
                'facilities' => [
                    'Laboratorium jaringan dengan router & switch industri',
                    'Server rack untuk praktik langsung',
                    'Akses internet dedicated untuk simulasi jaringan',
                    'Perangkat lunak simulasi jaringan (Cisco Packet Tracer, dll)',
                ],
                'careers' => ['Network Administrator', 'Teknisi Jaringan', 'IT Support', 'Wirausaha Jasa Instalasi Jaringan'],
            ],
            [
                'slug' => 'mp',
                'code' => 'MP',
                'name' => 'Manajemen Perkantoran',
                'desc' => 'Pengelolaan administrasi perkantoran, komunikasi bisnis, dan layanan pelanggan.',
                'icon' => 'briefcase',
                'logo' => 'images/jurusan/mp/logo.png',
                'color_from' => 'from-skblue-400',
                'color_to' => 'to-skblue-600',
                'description' => "Program keahlian Manajemen Perkantoran membekali siswa dengan keterampilan administrasi, korespondensi bisnis, kearsipan, serta pengelolaan layanan pelanggan yang profesional.\n\nSiswa dilatih menggunakan aplikasi perkantoran modern, teknik komunikasi bisnis yang efektif, serta manajemen dokumen dan kearsipan digital maupun konvensional.",
                'facilities' => [
                    'Laboratorium perkantoran & simulasi kerja',
                    'Perangkat lunak administrasi & kearsipan digital',
                    'Ruang praktik customer service',
                    'Pelatihan korespondensi bisnis',
                ],
                'careers' => ['Staff Administrasi', 'Sekretaris', 'Customer Service', 'Wirausaha Jasa Administrasi'],
            ],
            [
                'slug' => 'atp',
                'code' => 'ATP',
                'name' => 'Agribisnis Tanaman Perkebunan',
                'desc' => 'Pengelolaan dan pengembangan tanaman perkebunan, termasuk praktik pertanian berkelanjutan.',
                'icon' => 'leaf',
                'logo' => 'images/jurusan/atp/logo.png',
                'color_from' => 'from-emerald-500',
                'color_to' => 'to-skblue-600',
                'description' => "Program keahlian Agribisnis Tanaman Perkebunan membekali siswa dengan pengetahuan dan keterampilan budidaya tanaman perkebunan, pengelolaan lahan, hingga aspek bisnis dari hasil perkebunan.\n\nSiswa dilatih langsung di lahan praktik sekolah, mempelajari teknik budidaya berkelanjutan, pengendalian hama terpadu, hingga strategi pemasaran hasil pertanian.",
                'facilities' => [
                    'Lahan praktik perkebunan sekolah',
                    'Green house untuk pembibitan',
                    'Peralatan pertanian modern',
                    'Kerja sama dengan kelompok tani & DUDI perkebunan',
                ],
                'careers' => ['Teknisi Perkebunan', 'Pengelola Lahan Pertanian', 'Wirausaha Agribisnis', 'Penyuluh Pertanian'],
            ],
        ];
    }

    // Halaman detail 1 jurusan — /jurusan/{slug}
    public function show(string $slug): Response|\Illuminate\View\View
    {
        $major = collect(self::data())->firstWhere('slug', $slug);

        abort_if(!$major, 404);

        $schoolName = Setting::get('school_name', 'SMK Negeri 1 Sebulu');
        $otherMajors = collect(self::data())->where('slug', '!=', $slug)->values();

        return view('jurusan-show', compact('major', 'otherMajors', 'schoolName'));
    }

}