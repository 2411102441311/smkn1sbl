@extends('layouts.public')

@section('title', 'Status Pendaftaran — ' . \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu'))

@section('content')

    <section class="bg-gradient-to-br from-skblue-700 to-skblue-500 py-16 md:py-20">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <div class="w-16 h-16 rounded-full bg-white/15 border border-white/25 flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="font-display font-extrabold text-white text-2xl md:text-3xl">Pendaftaran Berhasil Dikirim</h1>
            <p class="text-white/90 mt-3">Simpan nomor pendaftaran ini untuk mengecek status Anda kapan saja.</p>
            <p class="font-display font-extrabold text-white text-3xl md:text-4xl mt-4 tracking-wide">
                {{ $registration->registration_number }}
            </p>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-6 py-14 space-y-6">

        @if(session('success'))
            <div class="rounded-2xl bg-green-50 border border-green-200 text-green-700 text-sm px-5 py-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Status --}}
        <div class="bg-white rounded-2xl border border-skblue-100 p-6">
            <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-2">Status Saat Ini</p>
            @php
                $statusMap = [
                    'draft' => ['label' => 'Draft', 'color' => 'bg-slate-100 text-slate-600'],
                    'submitted' => ['label' => 'Menunggu Verifikasi Berkas', 'color' => 'bg-amber-100 text-amber-700'],
                    'documents_valid' => ['label' => 'Berkas Valid', 'color' => 'bg-blue-100 text-blue-700'],
                    'documents_invalid' => ['label' => 'Berkas Perlu Diperbaiki', 'color' => 'bg-red-100 text-red-700'],
                    'graded' => ['label' => 'Nilai Sedang Diproses', 'color' => 'bg-blue-100 text-blue-700'],
                    'recommended' => ['label' => 'Rekomendasi Jurusan Tersedia', 'color' => 'bg-skblue-100 text-skblue-700'],
                    'accepted' => ['label' => 'Diterima', 'color' => 'bg-green-100 text-green-700'],
                    'rejected' => ['label' => 'Tidak Diterima', 'color' => 'bg-red-100 text-red-700'],
                ];
                $current = $statusMap[$registration->status] ?? ['label' => ucfirst($registration->status), 'color' => 'bg-slate-100 text-slate-600'];
            @endphp
            <span class="inline-block text-sm font-semibold rounded-full px-4 py-1.5 {{ $current['color'] }}">
                {{ $current['label'] }}
            </span>
        </div>

        {{-- Biodata ringkas --}}
        <div class="bg-white rounded-2xl border border-skblue-100 p-6">
            <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-3">Data Pendaftar</p>
            <div class="grid sm:grid-cols-2 gap-3 text-sm">
                <p><span class="text-slate-400">Nama:</span> <span class="font-medium text-slate-700">{{ $registration->biodata->name ?? '-' }}</span></p>
                <p><span class="text-slate-400">Asal Sekolah:</span> <span class="font-medium text-slate-700">{{ $registration->biodata->school_origin ?? '-' }}</span></p>
            </div>
        </div>

        {{-- Pilihan jurusan --}}
        <div class="bg-white rounded-2xl border border-skblue-100 p-6">
            <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-3">Pilihan Jurusan</p>
            <ol class="space-y-2">
                @forelse($registration->majorChoices as $choice)
                    <li class="flex items-center gap-3 text-sm">
                        <span class="w-6 h-6 rounded-full bg-skblue-100 text-skblue-700 font-bold text-xs flex items-center justify-center shrink-0">{{ $choice->choice_order }}</span>
                        {{ $choice->major->name ?? '-' }}
                    </li>
                @empty
                    <p class="text-sm text-slate-400">Belum ada pilihan jurusan.</p>
                @endforelse
            </ol>
        </div>

        {{-- Hasil OCR / nilai rapor --}}
        @if($registration->reportCards->isNotEmpty())
            <div class="bg-white rounded-2xl border border-skblue-100 p-6">
                <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-3">Nilai Rapor (Hasil Pembacaan Otomatis)</p>
                @php $ocr = $registration->reportCards->first()->ocrResult; @endphp
                @if($ocr && !empty($ocr->extracted_data))
                    <div class="grid sm:grid-cols-2 gap-2 text-sm mb-3">
                        @foreach($ocr->extracted_data as $subject => $grade)
                            <p class="flex justify-between border-b border-skblue-50 py-1.5">
                                <span class="text-slate-500">{{ $subject }}</span>
                                <span class="font-semibold text-slate-700">{{ $grade }}</span>
                            </p>
                        @endforeach
                    </div>
                    <p class="text-xs {{ $ocr->is_confirmed ? 'text-green-600' : 'text-amber-600' }}">
                        {{ $ocr->is_confirmed ? '✓ Nilai sudah dikonfirmasi.' : '⚠ Nilai belum dikonfirmasi — hubungi panitia PPDB untuk verifikasi.' }}
                        (Keyakinan pembacaan: {{ $ocr->confidence_score }}%)
                    </p>
                @else
                    <p class="text-sm text-slate-400">Nilai belum berhasil dibaca otomatis. Panitia akan memproses secara manual.</p>
                @endif
            </div>
        @endif

        {{-- Rekomendasi jurusan (SAW) --}}
        @if($registration->sawResult)
            <div class="bg-skblue-50 rounded-2xl border border-skblue-100 p-6">
                <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-2">Rekomendasi Sistem</p>
                <p class="font-display font-bold text-xl text-skblue-900">
                    {{ $registration->sawResult->recommendedMajor->name ?? '-' }}
                </p>
                <p class="text-sm text-slate-500 mt-1">Berdasarkan analisis nilai rapor Anda menggunakan metode SAW.</p>
            </div>
        @endif

        <a href="{{ route('home') }}" class="block text-center text-sm font-semibold text-skblue-600 hover:text-skblue-800 transition">
            ← Kembali ke Beranda
        </a>
    </section>

@endsection