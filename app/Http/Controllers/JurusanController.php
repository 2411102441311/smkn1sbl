<?php

namespace App\Http\Controllers;

use App\Data\JurusanData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = JurusanData::all();

        return view('jurusan.index', compact('jurusan'));
    }

    public function show(string $slug)
    {
        $item = JurusanData::find($slug);

        abort_if($item === null, Response::HTTP_NOT_FOUND);

        // Jurusan lain untuk rekomendasi "lihat jurusan lain" di bagian bawah halaman detail
        $lainnya = collect(JurusanData::all())
            ->where('slug', '!=', $slug)
            ->take(3)
            ->values()
            ->all();

        return view('jurusan.show', ['jurusan' => $item, 'lainnya' => $lainnya]);
    }
}
