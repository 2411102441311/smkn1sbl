@extends('layouts.public')

@section('title', 'Profil Sekolah — ' . ($schoolName ?? 'SMK Negeri 1 Sebulu'))

@section('content')

    {{-- ============ PAGE HEADER ============ --}}
    <section class="relative isolate">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="{{ asset('images/hero-bg.jpg') }}"
                
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-skblue-900/90 via-skblue-800/80 to-skblue-600/60"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 py-24 md:py-32 text-center">
            <p class="inline-block text-xs font-semibold tracking-widest uppercase text-skblue-100 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 backdrop-blur-sm mb-5">
                Tentang {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}
            </p>
            <h1 class="font-display font-extrabold text-white text-4xl md:text-5xl">Profil Sekolah</h1>
            <p class="text-skblue-50/90 max-w-xl mx-auto mt-4">
                {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }} — Mencetak generasi unggul, kompeten, dan berkarakter.
            </p>
        </div>
    </section>

    {{-- ============ TAB NAVIGASI (anchor) ============ --}}
    <div class="sticky top-[57px] z-40 bg-white border-b border-skblue-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-5 overflow-x-auto">
            <div class="flex justify-start lg:justify-center gap-2.5 whitespace-nowrap">
                <a href="sejarah" class="px-5 py-2.5 rounded-full border border-skblue-100 bg-skblue-50/60 text-sm font-semibold text-skblue-700 hover:bg-skblue-600 hover:text-white hover:border-skblue-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Sejarah</a>
                <a href="visi-misi" class="px-5 py-2.5 rounded-full border border-skblue-100 bg-skblue-50/60 text-sm font-semibold text-skblue-700 hover:bg-skblue-600 hover:text-white hover:border-skblue-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Visi &amp; Misi</a>
                <a href="struktur" class="px-5 py-2.5 rounded-full border border-skblue-100 bg-skblue-50/60 text-sm font-semibold text-skblue-700 hover:bg-skblue-600 hover:text-white hover:border-skblue-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Struktur Organisasi</a>
                <a href="guru" class="px-5 py-2.5 rounded-full border border-skblue-100 bg-skblue-50/60 text-sm font-semibold text-skblue-700 hover:bg-skblue-600 hover:text-white hover:border-skblue-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Daftar Guru</a>
                <a href="prestasi" class="px-5 py-2.5 rounded-full border border-skblue-100 bg-skblue-50/60 text-sm font-semibold text-skblue-700 hover:bg-skblue-600 hover:text-white hover:border-skblue-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Prestasi</a>
                <a href="ekstrakurikuler" class="px-5 py-2.5 rounded-full border border-skblue-100 bg-skblue-50/60 text-sm font-semibold text-skblue-700 hover:bg-skblue-600 hover:text-white hover:border-skblue-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Ekstrakurikuler</a>
            </div>
        </div>
    </div>

    {{-- Jarak napas sebelum konten section pertama --}}
    <div class="h-10 md:h-14"></div>

    {{-- ============ SEJARAH ============ --}}
    <section id="sejarah" class="max-w-5xl mx-auto px-6 py-20 scroll-mt-32">
        <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Sejarah</p>
        <h2 class="font-display font-extrabold text-3xl text-slate-800 mb-6 reveal">
            Perjalanan {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}
        </h2>
        <div class="w-16 h-1 bg-skblue-500 rounded-full mb-6 reveal"></div>
        <div class="text-slate-600 leading-relaxed space-y-4 reveal">
            @foreach(explode("\n\n", $history['text']) as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
        <div class="mt-8 flex flex-wrap gap-4 reveal">
            <div class="bg-skblue-50 border border-skblue-100 rounded-xl px-5 py-3">
                <p class="text-xs text-skblue-500 font-semibold uppercase">Tahun Berdiri</p>
                <p class="font-display font-bold text-skblue-900">{{ $history['founded_year'] }}</p>
            </div>
            <div class="bg-skblue-50 border border-skblue-100 rounded-xl px-5 py-3">
                <p class="text-xs text-skblue-500 font-semibold uppercase">Dasar Hukum</p>
                <p class="font-display font-bold text-skblue-900">{{ $history['sk_number'] }}</p>
            </div>
        </div>
    </section>

    {{-- ============ VISI & MISI ============ --}}
    <section id="visi-misi" class="bg-skblue-50/60 py-20 scroll-mt-24">
        <div class="max-w-5xl mx-auto px-6">
            <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Visi &amp; Misi</p>
            <h2 class="font-display font-extrabold text-3xl text-slate-800 mb-10 reveal">Arah &amp; Tujuan Kami</h2>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl p-8 border border-skblue-100 reveal-left">
                    <div class="w-11 h-11 rounded-xl bg-skblue-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-skblue-900 mb-3">Visi</h3>
                    <p class="text-slate-600 leading-relaxed">{{ $vision }}</p>
                </div>

                <div class="bg-white rounded-2xl p-8 border border-skblue-100 reveal-right">
                    <div class="w-11 h-11 rounded-xl bg-skblue-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-skblue-900 mb-4">Misi</h3>
                    <ul class="space-y-3">
                        @foreach($missions as $mission)
                            <li class="flex items-start gap-2.5 text-sm text-slate-600 leading-relaxed">
                                <span class="shrink-0 w-1.5 h-1.5 rounded-full bg-skblue-500 mt-2"></span>
                                {{ $mission }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ STRUKTUR ORGANISASI ============ --}}
    <section id="struktur" class="max-w-5xl mx-auto px-6 py-20 scroll-mt-24">
        <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Struktur</p>
        <h2 class="font-display font-extrabold text-3xl text-slate-800 mb-10 reveal">Struktur Organisasi</h2>

        <div class="space-y-3">
            @foreach($orgStructure as $item)
                <div class="reveal flex items-center gap-4" style="margin-left: {{ ($item['level'] - 1) * 32 }}px">
                    <span class="shrink-0 w-2 h-2 rounded-full bg-skblue-500"></span>
                    <div class="flex-1 bg-white border border-skblue-100 rounded-xl px-5 py-3 font-medium text-slate-700 hover:border-skblue-300 hover:shadow-soft transition-all duration-200">
                        {{ $item['role'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ DAFTAR GURU ============ --}}
    <section id="guru" class="bg-skblue-50/60 py-20 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Tenaga Pendidik</p>
            <h2 class="font-display font-extrabold text-3xl text-slate-800 mb-10 reveal">Daftar Guru &amp; Tenaga Kependidikan</h2>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($teachers as $teacher)
                    @php
                        $teacherPhoto = !empty($teacher['foto']) ? asset('images/guru/' . $teacher['foto']) : null;
                    @endphp
                    <div class="bg-white rounded-2xl border border-skblue-100 p-5 text-center hover:shadow-soft hover:-translate-y-1 transition-all duration-200 reveal reveal-delay-{{ $loop->iteration % 4 }}">
                        @if($teacherPhoto)
                            <img src="{{ $teacherPhoto }}" alt="{{ $teacher['name'] }}" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm mx-auto mb-3">
                        @else
                            <div class="w-16 h-16 rounded-full bg-skblue-100 mx-auto mb-3 flex items-center justify-center">
                                <svg class="w-8 h-8 text-skblue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        <p class="font-display font-semibold text-slate-800 text-sm">{{ $teacher['name'] }}</p>
                        <p class="text-xs text-skblue-500 mt-1">{{ $teacher['subject'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ PRESTASI ============ --}}
    <section id="prestasi" class="max-w-7xl mx-auto px-6 py-20 scroll-mt-24">
        <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Pencapaian</p>
        <h2 class="font-display font-extrabold text-3xl text-slate-800 mb-10 reveal">Prestasi Sekolah</h2>

        <div class="grid sm:grid-cols-2 gap-5">
            @foreach($achievements as $item)
                <div class="flex items-start gap-4 bg-white border border-skblue-100 rounded-2xl p-5 hover:border-skblue-300 hover:shadow-soft transition-all duration-200 reveal">
                    <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-skgold-400 to-skgold-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 01-2 2H5a2 2 0 01-2-2v-4a2 2 0 012-2h2a2 2 0 012 2v4zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v8m0 0a2 2 0 002 2h2a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-skblue-500">{{ $item['year'] }}</p>
                        <p class="font-display font-bold text-slate-800">{{ $item['title'] }}</p>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $item['category'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ EKSTRAKURIKULER ============ --}}
    <section id="ekstrakurikuler" class="bg-skblue-50/60 py-20 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Kegiatan</p>
            <h2 class="font-display font-extrabold text-3xl text-slate-800 mb-10 reveal">Ekstrakurikuler</h2>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
                @foreach($extracurriculars as $eskul)
                    <div class="bg-white rounded-2xl border border-skblue-100 p-6 text-center hover:border-skblue-300 hover:shadow-soft hover:-translate-y-1 transition-all duration-200 reveal-zoom">
                        <div class="w-12 h-12 rounded-xl bg-skblue-600 mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8m-9 8h10a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="font-display font-semibold text-slate-800 text-sm">{{ $eskul['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection