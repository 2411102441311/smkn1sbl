@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $cards = [
                ['label' => 'Total Pendaftar PPDB', 'value' => $stats['total_registrations'], 'icon' => 'M12 4v16m8-8H4', 'color' => 'bg-skblue-600'],
                ['label' => 'Menunggu Verifikasi', 'value' => $stats['total_registrations_submitted'], 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-amber-500'],
                ['label' => 'Diterima', 'value' => $stats['total_registrations_accepted'], 'icon' => 'M5 13l4 4L19 7', 'color' => 'bg-green-600'],
                ['label' => 'Total Pengguna', 'value' => $stats['total_users'], 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4', 'color' => 'bg-purple-600'],
                ['label' => 'Berita Terpublikasi', 'value' => $stats['total_news'], 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'color' => 'bg-skblue-500'],
                ['label' => 'Halaman Terpublikasi', 'value' => $stats['total_pages'], 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'bg-skblue-400'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white rounded-2xl border border-skblue-100 p-5">
                <div class="w-10 h-10 rounded-xl {{ $card['color'] }} flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <p class="font-extrabold text-2xl text-slate-800">{{ $card['value'] }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $card['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-skblue-100 p-6">
            <h2 class="font-bold text-slate-800 mb-5">Pendaftaran per Status</h2>

            @php
                $statusLabels = [
                    'draft' => 'Draft',
                    'submitted' => 'Menunggu Verifikasi',
                    'documents_valid' => 'Berkas Valid',
                    'documents_invalid' => 'Berkas Ditolak',
                    'graded' => 'Nilai Diproses',
                    'recommended' => 'Direkomendasikan',
                    'accepted' => 'Diterima',
                    'rejected' => 'Ditolak',
                ];
                $maxCount = $registrationByStatus->max() ?: 1;
            @endphp

            @forelse($registrationByStatus as $status => $count)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-slate-600">{{ $statusLabels[$status] ?? ucfirst($status) }}</span>
                        <span class="text-skblue-600 font-semibold">{{ $count }}</span>
                    </div>
                    <div class="w-full h-2 bg-skblue-50 rounded-full overflow-hidden">
                        <div class="h-full bg-skblue-500 rounded-full" style="width: {{ ($count / $maxCount) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400">Belum ada data pendaftaran.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-2xl border border-skblue-100 p-6">
            <h2 class="font-bold text-slate-800 mb-5">Tren Pendaftaran per Bulan</h2>

            @php $maxTrend = $registrationTrend->max('total') ?: 1; @endphp

            @forelse($registrationTrend as $trend)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-slate-600">{{ \Carbon\Carbon::createFromFormat('Y-m', $trend->month)->translatedFormat('F Y') }}</span>
                        <span class="text-skblue-600 font-semibold">{{ $trend->total }}</span>
                    </div>
                    <div class="w-full h-2 bg-skblue-50 rounded-full overflow-hidden">
                        <div class="h-full bg-skblue-400 rounded-full" style="width: {{ ($trend->total / $maxTrend) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400">Belum ada data pendaftaran.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-8">
        <h2 class="font-bold text-slate-800 mb-4">Akses Cepat</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.ppdb.verification.index') }}" class="bg-skblue-50 hover:bg-skblue-100 rounded-2xl p-5 border border-skblue-100 transition">
                <p class="font-semibold text-skblue-900 text-sm">Verifikasi Berkas PPDB</p>
                <p class="text-xs text-skblue-500 mt-1">Cek pendaftar yang menunggu</p>
            </a>
            <a href="{{ route('admin.cms.news.index') }}" class="bg-skblue-50 hover:bg-skblue-100 rounded-2xl p-5 border border-skblue-100 transition">
                <p class="font-semibold text-skblue-900 text-sm">Tulis Berita Baru</p>
                <p class="text-xs text-skblue-500 mt-1">Update info sekolah</p>
            </a>
            <a href="{{ route('admin.cms.gallery.index') }}" class="bg-skblue-50 hover:bg-skblue-100 rounded-2xl p-5 border border-skblue-100 transition">
                <p class="font-semibold text-skblue-900 text-sm">Upload Foto Galeri</p>
                <p class="text-xs text-skblue-500 mt-1">Dokumentasi kegiatan</p>
            </a>
            <a href="{{ route('admin.reports.ppdb.index') }}" class="bg-skblue-50 hover:bg-skblue-100 rounded-2xl p-5 border border-skblue-100 transition">
                <p class="font-semibold text-skblue-900 text-sm">Laporan PPDB</p>
                <p class="text-xs text-skblue-500 mt-1">Export Excel / PDF</p>
            </a>
        </div>
    </div>
@endsection
