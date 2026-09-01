<?php

namespace App\Data;

/**
 * Sumber data untuk halaman profil sekolah.
 *
 * Data ini bersifat statis dan digunakan langsung oleh ProfilController.
 * Jika halaman profil kelak dipindahkan ke model/database, maka konten ini dapat
 * dipindahkan ke migration + seeder / model yang sesuai.
 */
class ProfilData
{
    /**
     * Ambil semua konten profil sekolah.
     *
     * @return array<string, array<int, mixed>>
     */
    public static function all(): array
    {
        return [
            'timeline' => [
                ['year' => '1998', 'text' => 'SMK Negeri 1 Sebulu resmi didirikan untuk menjawab kebutuhan tenaga terampil di Kutai Kartanegara.'],
                ['year' => '2005', 'text' => 'Pembukaan jurusan Teknik Kendaraan Ringan dan Akuntansi seiring bertambahnya animo pendaftar.'],
                ['year' => '2014', 'text' => 'Sekolah meraih Akreditasi A dan membangun laboratorium jaringan komputer baru.'],
                ['year' => '2021', 'text' => 'Pembukaan jurusan Multimedia dan Agribisnis Tanaman Perkebunan.'],
                ['year' => '2026', 'text' => 'SMK Negeri 1 Sebulu terus berkembang dengan 6 kompetensi keahlian dan kemitraan 20+ industri.'],
            ],
            'misi' => [
                'Menyelenggarakan pendidikan kejuruan yang adaptif terhadap kebutuhan dunia usaha dan industri.',
                'Membentuk karakter siswa yang disiplin, jujur, dan bertanggung jawab.',
                'Mengembangkan kompetensi siswa melalui praktik nyata dan kemitraan industri.',
                'Meningkatkan mutu pendidik dan tenaga kependidikan secara berkelanjutan.',
                'Menumbuhkan jiwa kewirausahaan pada setiap lulusan.',
            ],
            'tujuan' => [
                'Menghasilkan lulusan yang kompeten dan siap kerja sesuai bidang keahlian.',
                'Menghasilkan lulusan yang mampu berwirausaha secara mandiri.',
                'Menyiapkan lulusan yang mampu melanjutkan pendidikan ke jenjang lebih tinggi.',
                'Membentuk lulusan yang berkarakter, disiplin, dan berakhlak mulia.',
            ],
            'struktur' => [
                'kepala' => 'Drs. Ahmad Fauzi, M.Pd. — Kepala Sekolah',
                'wakil' => [
                    ['title' => 'Waka Kurikulum', 'name' => 'Siti Rahmawati, S.Pd.'],
                    ['title' => 'Waka Kesiswaan', 'name' => 'Budi Santoso, S.Pd.'],
                    ['title' => 'Waka Sarana Prasarana', 'name' => 'Herman, S.T.'],
                    ['title' => 'Waka Humas & Hubin', 'name' => 'Nurul Aini, S.Pd.'],
                ],
                'kaprog' => [
                    'Kaprog TKJ', 'Kaprog TKR', 'Kaprog AKL', 'Kaprog Tata Boga', 'Kaprog Multimedia', 'Kaprog ATP',
                ],
            ],
            'guru' => [
                ['nama' => 'Siti Rahmawati, S.Pd.', 'jabatan' => 'Guru Matematika / Waka Kurikulum'],
                ['nama' => 'Budi Santoso, S.Pd.', 'jabatan' => 'Guru BK / Waka Kesiswaan'],
                ['nama' => 'Herman, S.T.', 'jabatan' => 'Guru Produktif TKJ'],
                ['nama' => 'Yusuf Hidayat, S.Pd.', 'jabatan' => 'Guru Produktif TKR'],
                ['nama' => 'Nurul Aini, S.Pd.', 'jabatan' => 'Guru Bahasa Indonesia'],
                ['nama' => 'Ratna Sari, S.Pd.', 'jabatan' => 'Guru Produktif Tata Boga'],
                ['nama' => 'Agus Prasetyo, S.Kom.', 'jabatan' => 'Guru Produktif Multimedia'],
                ['nama' => 'Dewi Lestari, S.P.', 'jabatan' => 'Guru Produktif ATP'],
            ],
            'tendik' => [
                ['nama' => 'Muhammad Iqbal', 'jabatan' => 'Kepala Tata Usaha'],
                ['nama' => 'Fitriani', 'jabatan' => 'Staf Administrasi'],
                ['nama' => 'Sukirno', 'jabatan' => 'Petugas Perpustakaan'],
                ['nama' => 'Aditya Pratama', 'jabatan' => 'Teknisi Laboratorium'],
            ],
        ];
    }
}
