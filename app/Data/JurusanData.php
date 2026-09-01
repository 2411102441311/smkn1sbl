<?php

namespace App\Data;

/**
 * Data Kompetensi Keahlian (Jurusan) SMK Negeri 1 Sebulu.
 *
 * Ini masih data statis contoh. Kalau sudah siap pakai database,
 * pindahkan isi array ini ke tabel `jurusans` (migration + model Jurusan),
 * lalu ganti pemanggilan JurusanData::all() di controller menjadi
 * \App\Models\Jurusan::all().
 */
class JurusanData
{
    public static function all(): array
    {
        return [
            [
                'slug' => 'tkj',
                'code' => 'SPEC. 01 / TKJ',
                'icon' => 'fa-network-wired',
                'color' => 'navy',
                'title' => 'Teknik Komputer & Jaringan',
                'desc' => 'Instalasi jaringan, administrasi server, dan keamanan sistem informasi.',
                'deskripsi_panjang' => 'Program keahlian Teknik Komputer & Jaringan (TKJ) membekali siswa dengan kemampuan merancang, memasang, dan merawat jaringan komputer, mengelola server, serta memahami dasar keamanan siber. Siswa dilatih langsung di laboratorium jaringan dengan perangkat mirip kondisi kerja di industri IT.',
                'kompetensi' => [
                    'Instalasi & konfigurasi jaringan LAN/WAN',
                    'Administrasi server (Linux & Windows Server)',
                    'Keamanan jaringan dasar & firewall',
                    'Troubleshooting perangkat keras dan jaringan',
                    'Cloud computing dasar',
                ],
                'fasilitas' => [
                    'Laboratorium jaringan dengan router & switch industri',
                    'Server rack praktik',
                    'Akses internet dedicated untuk simulasi jaringan',
                ],
                'prospek' => [
                    'Teknisi Jaringan', 'IT Support', 'Network Administrator', 'Wirausaha Jasa Komputer',
                ],
            ],
           
            [
                'slug' => 'mp',
                'code' => 'SPEC. 02 / MP',
                'icon' => 'fa-briefcase',
                'color' => 'gold',
                'title' => 'Manajemen Perkantoran',
                'desc' => 'Pengelolaan administrasi perkantoran, komunikasi bisnis, dan layanan pelanggan.',
                'deskripsi_panjang' => 'Program keahlian Manajemen Perkantoran (MP) membekali siswa dengan kemampuan mengelola administrasi dan kearsipan kantor, menangani surat-menyurat, korespondensi bisnis, hingga memberikan layanan pelanggan yang profesional. Siswa dilatih langsung dengan simulasi perkantoran modern berbasis komputer.',
                'kompetensi' => [
                    'Kearsipan & administrasi perkantoran',
                    'Korespondensi & surat-menyurat bisnis',
                    'Aplikasi perkantoran berbasis komputer',
                    'Layanan prima & komunikasi bisnis',
                    'Manajemen kegiatan rapat & agenda pimpinan',
                ],
                'fasilitas' => [
                    'Laboratorium perkantoran & simulasi kearsipan',
                    'Ruang praktik resepsionis & customer service',
                    'Perangkat lunak administrasi perkantoran',
                ],
                'prospek' => [
                    'Staf Administrasi', 'Sekretaris', 'Resepsionis', 'Customer Service', 'Wirausaha Jasa Administrasi',
                ],
            ],
           
            [
                'slug' => 'atp',
                'code' => 'SPEC. 03 / ATP',
                'icon' => 'fa-seedling',
                'color' => 'green',
                'title' => 'Agribisnis Tanaman Perkebunan',
                'desc' => 'Budidaya, pengolahan hasil, dan agribisnis lahan perkebunan lokal.',
                'deskripsi_panjang' => 'Program keahlian Agribisnis Tanaman Perkebunan membekali siswa dengan kemampuan budidaya tanaman perkebunan unggulan Kalimantan Timur, pengolahan hasil panen, hingga dasar manajemen usaha agribisnis di lahan praktik sekolah.',
                'kompetensi' => [
                    'Budidaya tanaman perkebunan (sawit, karet, dll)',
                    'Pengendalian hama & penyakit tanaman',
                    'Pengolahan hasil perkebunan',
                    'Manajemen lahan & alat pertanian',
                    'Dasar kewirausahaan agribisnis',
                ],
                'fasilitas' => [
                    'Lahan praktik perkebunan sekolah',
                    'Green house pembibitan',
                    'Alat & mesin pertanian dasar',
                ],
                'prospek' => [
                    'Teknisi Perkebunan', 'Penyuluh Pertanian', 'Pengelola Lahan', 'Wirausaha Agribisnis',
                ],
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        foreach (self::all() as $jurusan) {
            if ($jurusan['slug'] === $slug) {
                return $jurusan;
            }
        }
        return null;
    }
}