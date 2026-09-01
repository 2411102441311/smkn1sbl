@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil')

@section('content')

    <section class="bg-gradient-to-br from-skblue-700 to-skblue-500 py-16 md:py-20">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <div class="w-16 h-16 rounded-full bg-white/15 border border-white/25 flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="font-display font-extrabold text-white text-2xl md:text-3xl">Pendaftaran Berhasil Dikirim!</h1>
            <p class="text-white/90 mt-3">Simpan nomor pendaftaran ini baik-baik.</p>
            <p class="font-display font-extrabold text-white text-3xl md:text-4xl mt-4 tracking-wide">
                {{ $registration->registration_number }}
            </p>
        </div>
    </section>

    <section class="max-w-2xl mx-auto px-6 py-14 space-y-6">

        <div class="bg-white rounded-2xl border border-skblue-100 p-6">
            <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-3">Ringkasan Pendaftaran</p>
            <div class="space-y-2 text-sm">
                <p class="flex justify-between"><span class="text-slate-400">Nama</span> <span class="font-medium text-slate-700">{{ $registration->biodata->name ?? '-' }}</span></p>
                <p class="flex justify-between"><span class="text-slate-400">Pilihan 1</span> <span class="font-medium text-slate-700">{{ $registration->majorChoices->firstWhere('choice_order', 1)?->major?->name ?? '-' }}</span></p>
                @if($registration->sawResult)
                    <p class="flex justify-between"><span class="text-slate-400">Rekomendasi Sistem</span> <span class="font-medium text-skblue-700">{{ $registration->sawResult->recommendedMajor->name ?? '-' }}</span></p>
                @endif
            </div>
        </div>

        <a href="{{ route('ppdb.wizard.downloadProof', $registration->registration_number) }}"
           class="flex items-center justify-center gap-2 rounded-2xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-4 shadow-md transition-all duration-200">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download Bukti Pendaftaran (PDF)
        </a>

        <p class="text-center text-xs text-slate-400">
            Anda bisa cek status pendaftaran kapan saja lewat nomor pendaftaran di atas.
        </p>

        <a href="{{ route('home') }}" class="block text-center text-sm font-semibold text-skblue-600 hover:text-skblue-800 transition">
            ← Kembali ke Beranda
        </a>
    </section>

@endsection