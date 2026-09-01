<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tickers')->insert([
            ['text' => 'Pendaftaran PPDB gelombang 1 dibuka 1–31 Agustus 2026'],
            ['text' => 'Jadwal Penilaian Tengah Semester Ganjil terbit minggu depan'],
            ['text' => 'Kunjungan industri Jurusan TKJ ke Balikpapan, 28 Juli 2026'],
            ['text' => 'Lomba LKS Tingkat Kabupaten — pendaftaran peserta dibuka'],
        ]);

        DB::table('hero_stats')->insert([
            ['value' => '6', 'label' => 'Kompetensi Keahlian'],
            ['value' => '850+', 'label' => 'Siswa Aktif'],
            ['value' => '62', 'label' => 'Tenaga Pendidik'],
            ['value' => '40+', 'label' => 'Prestasi 3 Tahun'],
        ]);

        DB::table('berita')->insert([
            [
                'day' => '18',
                'month' => 'Jul',
                'category' => 'Kegiatan Siswa',
                'title' => 'Siswa TKJ Praktik Kerja Lapangan di Balikpapan',
                'excerpt' => 'Sebanyak 30 siswa jurusan TKJ memulai program magang di perusahaan mitra industri.',
                'icon' => 'fa-people-group',
                'color' => 'green',
            ],
            [
                'day' => '10',
                'month' => 'Jul',
                'category' => 'Prestasi',
                'title' => 'Juara 1 LKS Tata Boga Tingkat Kabupaten Kukar',
                'excerpt' => 'Tim kuliner sekolah meraih juara pertama dalam kompetisi keahlian tingkat kabupaten.',
                'icon' => 'fa-trophy',
                'color' => 'navy',
            ],
            [
                'day' => '02',
                'month' => 'Jul',
                'category' => 'Kemitraan',
                'title' => 'Penandatanganan MoU dengan Bengkel Mitra Otomotif',
                'excerpt' => 'Kerja sama baru memperluas akses praktik kerja bagi siswa jurusan TKR.',
                'icon' => 'fa-handshake',
                'color' => 'gold',
            ],
        ]);

        DB::table('fasilitas')->insert([
            ['icon' => 'fa-laptop-code', 'title' => 'Lab Komputer & Jaringan'],
            ['icon' => 'fa-car', 'title' => 'Bengkel Otomotif'],
            ['icon' => 'fa-utensils', 'title' => 'Dapur Praktik Boga'],
            ['icon' => 'fa-book', 'title' => 'Perpustakaan Digital'],
            ['icon' => 'fa-futbol', 'title' => 'Lapangan Olahraga'],
            ['icon' => 'fa-mosque', 'title' => 'Musala Sekolah'],
            ['icon' => 'fa-house-medical', 'title' => 'UKS & Ruang Kesehatan'],
            ['icon' => 'fa-tractor', 'title' => 'Lahan Praktik Agribisnis'],
        ]);

        DB::table('prestasi')->insert([
            [
                'icon' => 'fa-trophy',
                'title' => 'Juara 1 LKS Tata Boga',
                'desc' => 'Lomba Kompetensi Siswa tingkat Kabupaten Kutai Kartanegara, 2026.',
                'level' => 'Tingkat Kabupaten',
            ],
            [
                'icon' => 'fa-medal',
                'title' => 'Juara 2 Debat Bahasa Inggris',
                'desc' => 'Kompetisi debat pelajar SMK se-Kalimantan Timur, 2025.',
                'level' => 'Tingkat Provinsi',
            ],
            [
                'icon' => 'fa-award',
                'title' => 'Juara 1 Desain Poster Digital',
                'desc' => 'Festival kreativitas siswa jurusan Multimedia se-Kaltim, 2025.',
                'level' => 'Tingkat Provinsi',
            ],
            [
                'icon' => 'fa-star',
                'title' => 'Sekolah Adiwiyata Kabupaten',
                'desc' => 'Penghargaan sekolah peduli lingkungan dari Pemkab Kutai Kartanegara.',
                'level' => 'Tingkat Kabupaten',
            ],
            [
                'icon' => 'fa-wrench',
                'title' => 'Juara 3 LKS Teknik Kendaraan Ringan',
                'desc' => 'Lomba Kompetensi Siswa bidang otomotif tingkat provinsi, 2024.',
                'level' => 'Tingkat Provinsi',
            ],
        ]);

        DB::table('galeri')->insert([
            ['icon' => 'fa-graduation-cap', 'label' => 'Upacara Bendera', 'color' => 'navy', 'size' => 'tall'],
            ['icon' => 'fa-server', 'label' => 'Praktik Jaringan', 'color' => 'green', 'size' => ''],
            ['icon' => 'fa-car-side', 'label' => 'Bengkel Otomotif', 'color' => 'gold', 'size' => 'wide'],
            ['icon' => 'fa-utensils', 'label' => 'Praktik Tata Boga', 'color' => 'navy2', 'size' => ''],
            ['icon' => 'fa-people-group', 'label' => 'MPLS Siswa Baru', 'color' => 'green2', 'size' => ''],
            ['icon' => 'fa-trophy', 'label' => 'Penyerahan Juara LKS', 'color' => 'gold2', 'size' => 'tall'],
            ['icon' => 'fa-seedling', 'label' => 'Lahan Agribisnis', 'color' => 'navy3', 'size' => ''],
        ]);

        DB::table('pengumuman')->insert([
            [
                'day' => '01',
                'month' => 'Agu',
                'title' => 'Pendaftaran PPDB 2026/2027 Gelombang 1 Dibuka',
                'desc' => 'Formulir dapat diisi secara daring melalui laman SPMB',
                'tag' => 'PPDB',
            ],
            [
                'day' => '25',
                'month' => 'Jul',
                'title' => 'Jadwal Penilaian Tengah Semester Ganjil',
                'desc' => 'Berlaku untuk seluruh tingkat kelas X, XI, dan XII',
                'tag' => 'Akademik',
            ],
            [
                'day' => '28',
                'month' => 'Jul',
                'title' => 'Kunjungan Industri Jurusan TKJ ke Balikpapan',
                'desc' => 'Diikuti oleh siswa kelas XI Teknik Komputer & Jaringan',
                'tag' => 'Kegiatan',
            ],
            [
                'day' => '05',
                'month' => 'Agu',
                'title' => 'Pembukaan Pendaftaran Peserta LKS Tingkat Kabupaten',
                'desc' => 'Perwakilan tiap jurusan wajib mengisi formulir kesediaan',
                'tag' => 'Kegiatan',
            ],
        ]);
    }
}    
