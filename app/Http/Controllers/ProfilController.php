<?php

namespace App\Http\Controllers;

use App\Data\ProfilData;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil sekolah.
     *
     * Konten halaman profil disimpan sebagai data statis di App\Data\ProfilData.
     * Ini membuat controller tetap tipis dan memudahkan pemeliharaan.
     * Jika nanti dibuat model / tabel database untuk profil, maka data ini
     * dapat dipindahkan ke migration + seeder yang sesuai.
     */
    public function index()
    {
        $profil = ProfilData::all();

        return view('profil', $profil);
    }
}
