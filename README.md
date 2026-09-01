# Sistem Informasi SMK Negeri 1 Sebulu

Struktur kode Laravel sesuai *Database Roadmap*: **CMS**, **Authentication**,
**PPDB**, **Theme Manager**, **Sistem Pakar**, **SPK**, dan **Reporting Module** —
masing-masing dipisah rapi ke Model / Controller / Migration / Seeder sendiri.

## Struktur Folder

```
app/
  Models/
    CMS/            Page, News, Gallery, Category, Announcement, Setting
    Auth/            Role, Permission, Profile   (User.php ada di app/Models)
    PPDB/            Applicant, Registration, Document, Verification
    ThemeManager/    Theme, ThemeSchedule, Banner
    Pakar/           Question, KnowledgeBase, Rule, Consultation, ConsultationAnswer, ConsultationResult
    SPK/             Criteria, Alternative, Evaluation, Ranking
  Http/Controllers/
    CMS/ Auth/ PPDB/ ThemeManager/ Pakar/ SPK/ Reporting/
    HomeController.php   -> homepage publik
  Exports/
    RegistrationsExport.php   -> export Excel data PPDB

database/
  migrations/        28 migration, urut sesuai relasi antar modul
  seeders/           1 seeder per modul + DatabaseSeeder

resources/views/
  layouts/public.blade.php   -> layout tema biru muda
  welcome.blade.php          -> homepage (wallpaper foto sekolah + bingkai mengambang)

routes/web.php        semua route dikelompokkan per modul
```

## Ringkasan Fungsi per Modul

| Modul | Fungsi Utama |
|---|---|
| **CMS** | CRUD halaman, berita, galeri, kategori, pengumuman, pengaturan situs |
| **Authentication** | Kelola user, role, permission (role-based access), profil |
| **PPDB** | Form pendaftaran publik, verifikasi berkas, status pendaftaran |
| **Theme Manager** | Ganti warna tema, upload foto wallpaper hero, jadwal tema otomatis, banner |
| **Sistem Pakar** | Mesin inferensi **Certainty Factor** untuk rekomendasi jurusan berdasarkan minat/gejala |
| **SPK** | Perankingan alternatif dengan metode **SAW (Simple Additive Weighting)** |
| **Reporting** | Dashboard statistik + export **PDF** (DomPDF) & **Excel** (Maatwebsite Excel) |

## Cara Menjalankan (di komputer Anda)

1. `composer install`
2. `cp .env.example .env` lalu isi kredensial database
3. `php artisan key:generate`
4. `php artisan storage:link` (agar foto/gambar bisa diakses publik)
5. `php artisan migrate --seed`
6. `php artisan serve`
7. Login admin default (dari `UserSeeder`):
   - Email: `admin@smkn1sebulu.sch.id`
   - Password: `password123` (segera ganti setelah login pertama)

> Catatan: `routes/auth.php` (login/register) memakai **Laravel Breeze** —
> jalankan `php artisan breeze:install blade` lalu `npm install && npm run build`
> jika belum terpasang.

## Tentang Homepage

- **Wallpaper foto sekolah**: upload lewat menu *Theme Manager > Themes > hero_image*.
  Sebelum diisi, homepage otomatis memakai foto placeholder agar tetap tampil bagus.
- **Bingkai mengambang** (kartu kaca/glassmorphism berisi 3 tombol cepat: PPDB,
  Konsultasi Jurusan, Pengumuman) tetap dipertahankan seperti versi awal yang disukai.
- **Warna**: diganti dari biru tua gelap menjadi gradasi **biru muda khas SMK**
  (`skblue-50` s.d. `skblue-900` di `tailwind.config` pada `layouts/public.blade.php`),
  dan otomatis mengikuti warna yang disimpan di tabel `themes` bila Anda ingin
  membuatnya dinamis sepenuhnya.
