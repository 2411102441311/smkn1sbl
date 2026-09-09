@extends('layouts.public')

@section('title', 'Pendaftaran PPDB Ditutup')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-xl text-center">

        <div class="mx-auto w-20 h-20 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3m0 4h.01M10.29 3.86l-7.2 12.48A2 2 0 004.82 19h14.36a2 2 0 001.73-2.66l-7.2-12.48a2 2 0 00-3.46 0z"/>
            </svg>
        </div>

        <p class="text-sm font-semibold uppercase tracking-widest text-skblue-600 mb-2">
            Pendaftaran PPDB
        </p>

        <h1 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800">
            Pendaftaran Sedang Ditutup
        </h1>

        <p class="text-slate-500 mt-4 leading-relaxed">
            {{ $message ?? 'Pendaftaran PPDB saat ini belum dibuka.' }}
            Silakan kembali lagi ketika periode pendaftaran sudah dibuka oleh sekolah.
        </p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 rounded-full bg-skblue-600 text-white font-semibold px-6 py-3 hover:bg-skblue-700 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</section>
@endsection
