@extends('layouts.app')

@section('title', 'SMK Negeri 1 Sebulu — Unggul, Kompeten, Berkarakter')

@section('content')

    @include('partials.hero', ['heroStats' => $heroStats])

    @include('partials.ticker', ['ticker' => $ticker])

    @include('partials.sambutan')

    @include('partials.stats', ['heroStats' => $heroStats])

    @include('partials.jurusan', ['jurusan' => $jurusan])

    @include('partials.berita', ['berita' => $berita])

    @include('partials.fasilitas', ['fasilitas' => $fasilitas])

    @include('partials.prestasi', ['prestasi' => $prestasi])

    @include('partials.galeri', ['galeri' => $galeri])

    @include('partials.pengumuman', ['pengumuman' => $pengumuman])

    @include('partials.cta-spmb')

@endsection
