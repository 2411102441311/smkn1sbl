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
            'founded_year' => '2011',
            'sk_number' => 'SK Pendirian Nomor 421.5/7783/Disdikbud.IV/2018',
            'text' => "Didirikan pada tahun 2011, sekolah ini bermula dari kebutuhan masyarakat Sebulu akan pendidikan kejuruan yang berkualitas. Sejak awal berdirinya, sekolah berkomitmen menyelenggarakan pendidikan yang memadukan penguasaan ilmu pengetahuan, keterampilan teknis, dan pembentukan karakter bagi peserta didik.\n\nSeiring berjalannya waktu, sekolah terus berkembang — baik dari sisi jumlah program keahlian, fasilitas praktik, maupun kerja sama dengan dunia usaha dan industri (DUDI) — hingga menjadi salah satu sekolah menengah kejuruan rujukan di Kutai Kartanegara.",
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

        // Kepala Sekolah — sengaja dipisah dari $teachers karena ditampilkan sebagai kartu
        // yang lebih menonjol/besar di atas grid guru (lihat resources/views/profil.blade.php).
        // TODO: ganti nama & nama file foto sesuai Kepala Sekolah yang sebenarnya.
        $principal = [
            'name' => 'Herjan, S.Pd.',
            'subject' => 'Kepala Sekolah',
            'nip' => '',
            'foto' => 'guru/kepsek.jpeg',
        ];

        // Catatan privasi: field 'nip' sengaja DISIMPAN di data ini untuk keperluan arsip/administrasi
        // internal, tapi TIDAK ditampilkan di halaman publik (lihat resources/views/profil.blade.php).
        // Field 'foto' berisi path relatif dari public/images/.
        // Kalau field 'foto' kosong atau filenya belum ada, otomatis fallback ke ikon avatar.
        $teachers = [
            //* guru dan kepala sekolah
            ['name' => 'Muhammad Alvi Randi, S.Pd.', 'subject' => 'Guru Pendidikan Bahasa Inggris dan Wakil Kepala Sekolah Bidang Kesiswaan', 'nip' => '', 'foto' => 'guru/alfi.jpeg'],
            ['name' => 'Harpani, S.Sos.', 'subject' => 'Guru PPKN, Wakil Kepala Sekolah Bidang HUMAS, dan Ketua BKK', 'nip' => '', 'foto' => 'guru/harpani.jpeg'],
            ['name' => 'Yazid Bustani, S.P.', 'subject' => 'Guru Produktif Perkebunan dan Wakil Kepala Sekolah Bidang Sarana Prasarana', 'nip' => '', 'foto' => 'guru/yazid.jpeg'],
            ['name' => 'Hartini, S.Pi.', 'subject' => 'Wakil Kepala Sekolah Bidang Kurikulum Koordinator PJBL', 'nip' => '', 'foto' => 'guru/hartini.jpeg'],

            ['name' => 'Sholehatusyadiah, S.Sos.', 'subject' => 'Kepala Program Keahlian Manajemen Perkantoran (MP)', 'nip' => '', 'foto' => 'guru/diah.jpeg'],
            ['name' => 'Ainun, S.Pd', 'subject' => 'Guru Keahlian Manajemen Perkantoran (MP) dan Pembina Pramuka Putri', 'nip' => '', 'foto' => 'guru/ainun.jpeg'],

            ['name' => 'Bahrul Ilmy, S.Kom.', 'subject' => 'Kepala Program Keahlian Teknik Komputer dan Jaringan (TKJ)', 'nip' => '', 'foto' => 'guru/bahrul.jpeg'],

            ['name' => 'Deny Irawan, S.P.', 'subject' => 'Guru Keahlian Agribisnis Tanaman Perkebunan', 'nip' => '', 'foto' => 'guru/deny.jpeg'],
            ['name' => 'Nugra Hartono, S.P.', 'subject' => 'Kepala Program Keahlian Agribisnis Tanaman Perkebunan', 'nip' => '', 'foto' => 'guru/nugra.jpeg'],

            ['name' => 'Ratnawati, S.Kom.', 'subject' => 'Wali Kelas XII TKJ dan Guru Keahlian Teknik Komputer dan Jaringan (TKJ)', 'nip' => '', 'foto' => 'guru/ratnawati.jpeg'],
            ['name' => 'Dima Muthia Rilla Sari, S.Pd.', 'subject' => 'Wakil Kelas X TKJ dan Pembina Osis', 'nip' => '', 'foto' => 'guru/dima.jpeg'],
            ['name' => 'Mira Wati, S.Pd.I.', 'subject' => 'Wakil Kelas XII MP, Laboran PAI, dan Pembina Ekskul Tari', 'nip' => '', 'foto' => 'guru/mira.jpeg'],
            ['name' => 'Suklisnawati, S.Pd.', 'subject' => 'Wali Kelas XI ATP dan Guru Matematika', 'nip' => '', 'foto' => 'guru/suklisnawati.jpeg'],
            ['name' => 'Rofii Hamdi, S.Pd.', 'subject' => 'Wali Kelas X ATP dan Guru Matematika', 'nip' => '', 'foto' => 'guru/rofii-hamdi.jpeg'],
            ['name' => 'Siti Musripah, S.Pd.', 'subject' => 'Wali Kelas XI MP dan Guru Bahasa Indonesia', 'nip' => '', 'foto' => 'guru/siti.jpeg'],
            ['name' => 'Yuliana, S.Pd.', 'subject' => 'Wali Kelas XI MP, Pembina UKS, dan Pembina Ekskul Padus', 'nip' => '', 'foto' => 'guru/yuliana.jpeg'],
            ['name' => 'Aida Alfionita, S.Pd.', 'subject' => 'Wali Kelas XII ATP dan Pembina Kerohanian Islam', 'nip' => '', 'foto' => 'guru/aida.jpeg'],
            ['name' => 'Feronike Tindaon, S.Pd.', 'subject' => 'Wali Kelas XI TKJ dan Pembina Kerohanian Kristen', 'nip' => '', 'foto' => 'guru/feronike.jpeg'],

            ['name' => 'Nurul Hidayah, S.Pd.', 'subject' => 'Guru BK', 'nip' => '', 'foto' => 'guru/nurul.jpeg'],
            ['name' => 'Sri Rezeki, S.Pd.', 'subject' => 'Guru Bahasa Inggris', 'nip' => '', 'foto' => 'guru/sri.jpeg'],
            ['name' => 'Karyono, S.Pd.', 'subject' => 'Guru PJOK', 'nip'=> '', 'foto' => 'guru/karyono.jpeg'],
            ['name' => 'Ikhwanul Ikhsan Fauzi, S.Pi', 'subject' => 'Guru Kreatif dan Kewirausahaan', 'nip' => '', 'foto' => 'guru/fauzi.jpeg'],
            ['name' => 'Titik Yulianto Hadi, S.Sos., S.Pd.', 'subject' => 'Kepala Laboratorium dan Bendahara', 'nip' => '', 'foto' => 'guru/titik.jpeg'],

            //* Tenaga Kependidikan
            ['name' => 'Ika Dyah Wulandari, S.M.', 'subject' => 'Staff Pelaksana Bidang Kepegawaian, Arsip, dan Surat', 'nip' => '', 'foto' => 'staff/ika.jpeg'],
            ['name' => 'Ibnu Aziz, S.Pd.I.', 'subject' => 'Staff Pelaksana Bidang Analisis Jabatan, Analisis Beban Kerja, dan DAPODIK', 'nip' => '', 'foto' => 'staff/ibnu.jpeg'],
            ['name' => 'Muhammad Al-Rasid, S.Pd.', 'subject' => 'Staff Pelaksana Bidang Bendahara Sekolah', 'nip' => '', 'foto' => 'staff/rasid.jpeg'],
            ['name' => 'Aidul Ismail', 'subject' => 'Staff Pelaksana Bidang Sarana Prasarana dan Pembina Pramuka Putra', 'nip' => '', 'foto' => 'staff/aidul.jpeg'],
            ['name' => 'Maulidati', 'subject' => 'Staff Pelaksana Bidang Kesiswaan dan Perpustakaan', 'nip' => '', 'foto' => 'staff/maulidati.jpeg'],
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
            ['name' => 'Futsal', 'icon' => 'futbol'],
            ['name' => 'Basket', 'icon' => 'basketball'],
            ['name' => 'Paskibra', 'icon' => 'flag'],
            ['name' => 'Rohis', 'icon' => 'book'],
            ['name' => 'PMR', 'icon' => 'heart'],
            ['name' => 'Robotik', 'icon' => 'microchip'],
        ];

        return view('profil', compact(
            'schoolName', 'history', 'vision', 'missions',
            'orgStructure', 'principal', 'teachers', 'achievements', 'extracurriculars'
        ));
    }
}