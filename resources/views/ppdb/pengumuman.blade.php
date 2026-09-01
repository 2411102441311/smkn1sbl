@extends('layouts.public')

@section('title', 'Pengumuman PPDB — ' . ($schoolName ?? 'SMK Negeri 1 Sebulu'))

@section('content')

{{-- ============ HEADER ============ --}}
<section class="bg-gradient-to-br from-skblue-800 via-skblue-700 to-skblue-600 py-16 md:py-20">
    <div class="max-w-5xl mx-auto px-6 text-center">

        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/15 border border-white/20 backdrop-blur-sm mb-5">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>

        <h1 class="font-display font-extrabold text-white text-3xl md:text-5xl">
            Pengumuman
        </h1>

        <p class="text-white/80 text-sm md:text-base mt-4 max-w-2xl mx-auto leading-relaxed">
            Informasi dan pengumuman terbaru terkait Penerimaan Peserta Didik Baru
            {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}.
        </p>

    </div>
</section>


{{-- ============ DAFTAR PENGUMUMAN ============ --}}
<section class="max-w-5xl mx-auto px-6 py-14 md:py-20">

    <div class="space-y-5">

        {{-- Pengumuman 1 --}}
        <div class="bg-white border border-skblue-100 rounded-2xl p-6 md:p-7 shadow-sm hover:shadow-soft transition">

            <div class="flex gap-4">

                <div class="shrink-0 w-11 h-11 rounded-xl bg-skblue-100 text-skblue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                    </svg>
                </div>

                <div class="flex-1">

                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-skblue-600 bg-skblue-50 rounded-full px-3 py-1">
                            PPDB
                        </span>

                        <span class="text-xs text-slate-400">
                            Tahun Pelajaran 2026/2027
                        </span>
                    </div>

                    <h2 class="font-display font-bold text-lg md:text-xl text-slate-800">
                        Pendaftaran Peserta Didik Baru Telah Dibuka
                    </h2>

                    <p class="text-sm text-slate-500 leading-relaxed mt-2">
                        Penerimaan Peserta Didik Baru {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}
                        untuk Tahun Pelajaran 2026/2027 telah dibuka.
                        Calon peserta didik dapat melakukan pendaftaran secara online
                        melalui halaman PPDB.
                    </p>

                    <a href="{{ route('ppdb.applicants.create') }}"
                       class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-skblue-600 hover:text-skblue-800 transition">

                        Daftar Sekarang

                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>

                    </a>

                </div>

            </div>

        </div>


        {{-- Pengumuman 2 --}}
        <div class="bg-white border border-skblue-100 rounded-2xl p-6 md:p-7 shadow-sm hover:shadow-soft transition">

            <div class="flex gap-4">

                <div class="shrink-0 w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div class="flex-1">

                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                            Seleksi
                        </span>

                        <span class="text-xs text-slate-400">
                            PPDB 2026/2027
                        </span>
                    </div>

                    <h2 class="font-display font-bold text-lg md:text-xl text-slate-800">
                        Informasi Seleksi dan Verifikasi Berkas
                    </h2>

                    <p class="text-sm text-slate-500 leading-relaxed mt-2">
                        Calon peserta didik yang telah melakukan pendaftaran wajib
                        memastikan seluruh data dan dokumen yang diunggah telah benar
                        dan sesuai dengan persyaratan yang ditentukan.
                    </p>

                    <a href="{{ route('ppdb.persyaratan') }}"
                       class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-skblue-600 hover:text-skblue-800 transition">

                        Lihat Persyaratan

                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>

                    </a>

                </div>

            </div>

        </div>


        {{-- Pengumuman 3 --}}
        <div class="bg-white border border-skblue-100 rounded-2xl p-6 md:p-7 shadow-sm hover:shadow-soft transition">

            <div class="flex gap-4">

                <div class="shrink-0 w-11 h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div class="flex-1">

                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-amber-600 bg-amber-50 rounded-full px-3 py-1">
                            Jadwal
                        </span>

                        <span class="text-xs text-slate-400">
                            PPDB 2026/2027
                        </span>
                    </div>

                    <h2 class="font-display font-bold text-lg md:text-xl text-slate-800">
                        Jadwal dan Tahapan PPDB
                    </h2>

                    <p class="text-sm text-slate-500 leading-relaxed mt-2">
                        Informasi mengenai jadwal pendaftaran, verifikasi berkas,
                        seleksi, hingga pengumuman hasil penerimaan peserta didik
                        akan disampaikan melalui halaman informasi PPDB.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Kembali --}}
    <div class="text-center mt-10">

        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-skblue-600 transition">

            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>

            Kembali ke Beranda

        </a>

    </div>

</section>

@endsection