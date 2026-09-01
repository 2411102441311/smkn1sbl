@extends('layouts.public')

@section('title', 'Persyaratan PPDB — ' . ($schoolName ?? 'SMK Negeri 1 Sebulu'))

@section('content')

<section class="bg-skblue-50/60 py-16 md:py-20">
    <div class="max-w-5xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="text-center mb-12">
    
            <h1 class="font-display font-extrabold text-3xl md:text-5xl text-slate-800">
                Persyaratan Pendaftaran
            </h1>

            <p class="text-slate-500 mt-4 max-w-2xl mx-auto">
                Persiapkan dokumen dan persyaratan berikut sebelum melakukan
                pendaftaran peserta didik baru di
                {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}.
            </p>
        </div>


        {{-- PERSYARATAN --}}
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Persyaratan Umum --}}
            <div class="bg-white rounded-2xl border border-skblue-100 shadow-sm p-6">

                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-xl bg-skblue-100 text-skblue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13 3v5h5"/>
                        </svg>
                    </div>

                    <h2 class="font-display font-bold text-xl text-slate-800">
                        Persyaratan Umum
                    </h2>
                </div>

                <ul class="space-y-4 text-sm text-slate-600">

                    <li class="flex gap-3">
                        <span class="text-skblue-600 font-bold">01.</span>
                        <span>Calon peserta didik merupakan lulusan SMP/MTs atau sederajat.</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600 font-bold">02.</span>
                        <span>Mengisi formulir pendaftaran PPDB secara lengkap dan benar.</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600 font-bold">03.</span>
                        <span>Memilih program keahlian sesuai dengan minat dan kemampuan.</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600 font-bold">04.</span>
                        <span>Memastikan seluruh data yang diberikan dapat dipertanggungjawabkan.</span>
                    </li>

                </ul>
            </div>


            {{-- Dokumen --}}
            <div class="bg-white rounded-2xl border border-skblue-100 shadow-sm p-6">

                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-xl bg-skblue-100 text-skblue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 21h10a2 2 0 002-2V7l-5-5H7a2 2 0 00-2 2v15a2 2 0 002 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14 2v5h5"/>
                        </svg>
                    </div>

                    <h2 class="font-display font-bold text-xl text-slate-800">
                        Dokumen yang Disiapkan
                    </h2>
                </div>

                <ul class="space-y-4 text-sm text-slate-600">

                    <li class="flex gap-3">
                        <span class="text-skblue-600">✓</span>
                        <span>Kartu Keluarga (KK)</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600">✓</span>
                        <span>Akta Kelahiran</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600">✓</span>
                        <span>KTP orang tua/wali</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600">✓</span>
                        <span>Surat Keterangan Lulus (SKL)/ Rapor 1 Semester Terakhir</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600">✓</span>
                        <span>Rapor atau dokumen nilai yang diperlukan</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="text-skblue-600">✓</span>
                        <span>Pas foto calon peserta didik</span>
                    </li>

                </ul>
            </div>

        </div>


        {{-- CATATAN --}}
        <div class="mt-8 bg-skblue-600 rounded-2xl p-6 text-white">

            <div class="flex gap-4">

                <div class="shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="font-display font-bold mb-1">
                        Perhatian
                    </h3>

                    <p class="text-sm text-white/85 leading-relaxed">
                        Pastikan seluruh dokumen yang diunggah memiliki kualitas
                        gambar yang jelas dan data yang sesuai dengan dokumen asli.
                        Persyaratan dapat disesuaikan dengan ketentuan PPDB yang
                        berlaku pada periode pendaftaran.
                    </p>
                </div>

            </div>

        </div>


        {{-- TOMBOL --}}
        <div class="flex justify-center mt-10">

            <a href="{{ route('ppdb.applicants.create') }}"
               class="inline-flex items-center gap-2 rounded-full bg-skblue-600 hover:bg-skblue-700 text-white font-bold px-7 py-3.5 shadow-lg shadow-skblue-200 transition">

                Daftar PPDB Sekarang

                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>

            </a>

        </div>

    </div>
</section>

@endsection