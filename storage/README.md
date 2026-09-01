# Homepage SMK Negeri 1 Sebulu — Laravel

Struktur file ini siap ditaruh ke dalam project Laravel yang sudah ada (atau project baru).

## Struktur folder

```
app/Http/Controllers/HomeController.php   → data (jurusan, berita, prestasi, dst) + return view
routes/web.php                            → route "/"
resources/views/layouts/app.blade.php     → layout utama (head, navbar, footer, asset)
resources/views/home.blade.php            → halaman depan, include semua partial
resources/views/partials/*.blade.php      → tiap section (hero, jurusan, berita, dll)
public/css/app.css                        → semua styling
public/js/app.js                          → navbar scroll, filter pengumuman, animasi reveal
```

## Cara pakai (project Laravel baru)

1. Buat project Laravel seperti biasa:
   ```
   composer create-project laravel/laravel smkn1-sebulu
   ```
2. Salin (copy-paste) folder `app`, `routes`, `resources`, dan `public` dari sini ke dalam project barumu — timpa file yang sama namanya (`web.php`, `Controller.php` cukup digabung isinya kalau sudah ada).
3. Jalankan:
   ```
   php artisan serve
   ```
4. Buka `http://localhost:8000` — halaman depan langsung tampil.

## Cara pakai (project Laravel yang sudah ada)

Cukup salin isi tiap file ke lokasi yang sama di projectmu:
- Tambahkan method `index()` di `HomeController` (atau buat controller baru).
- Tambahkan route `Route::get('/', ...)` di `routes/web.php`.
- Copy semua `resources/views/partials/*.blade.php` dan `resources/views/home.blade.php`.
- Copy `public/css/app.css` dan `public/js/app.js`.

## Mengganti data jadi dinamis dari database

Semua data (jurusan, berita, prestasi, fasilitas, galeri, pengumuman) saat ini masih array contoh di dalam `HomeController@index`. Langkah lanjutan yang wajar:

1. Buat model + migration, misalnya:
   ```
   php artisan make:model Jurusan -m
   php artisan make:model Berita -m
   php artisan make:model Prestasi -m
   php artisan make:model Pengumuman -m
   ```
2. Ganti array di controller jadi query, contoh:
   ```php
   $jurusan = \App\Models\Jurusan::all();
   ```
   Struktur field di migration tinggal disesuaikan dengan key array yang sudah dipakai di blade (`code`, `icon`, `color`, `title`, `desc`, dst) supaya blade tidak perlu diubah.
3. Untuk galeri/berita dengan gambar asli, tambahkan field `image_url` lalu ganti `<i class="fa-solid ...">` di partial dengan `<img src="{{ $item->image_url }}">`.

## Catatan desain

- Warna sekolah: navy (`--navy-900` dst), hijau (`--green-600` dst), emas (`--gold-500` dst) — sesuai design system di roadmap.
- Font: Poppins (judul) + Inter (isi), ikon pakai Font Awesome — dimuat lewat CDN di `layouts/app.blade.php`.
- Semua ilustrasi (gedung, foto kepala sekolah, galeri) memakai SVG/gradient buatan, bukan foto asli — tinggal diganti `<img>` kalau sudah ada foto sekolah sungguhan.
