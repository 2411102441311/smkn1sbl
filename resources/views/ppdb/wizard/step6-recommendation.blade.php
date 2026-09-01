@extends('layouts.public')

@section('title', 'Pendaftaran — Rekomendasi Jurusan')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 6])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Rekomendasi Jurusan Untuk Anda</h1>
        <p class="text-sm text-slate-500 mb-6">Langkah 6 dari 7 — dihitung otomatis dari nilai rapor.</p>

        {{-- Kartu rekomendasi utama --}}
        @if($recommendedMajor)
            <div class="bg-gradient-to-br {{ $recommendedMajor->color_from }} {{ $recommendedMajor->color_to }} rounded-3xl p-8 text-center text-white mb-6">
                <p class="text-xs font-bold uppercase tracking-widest text-white/80 mb-3">Paling Direkomendasikan</p>
                <div class="mx-auto mb-4">
                    @include('partials.major-badge', ['major' => [
                        'name' => $recommendedMajor->name, 'logo' => $recommendedMajor->logo, 'icon' => $recommendedMajor->icon,
                        'color_from' => $recommendedMajor->color_from, 'color_to' => $recommendedMajor->color_to,
                    ], 'size' => 'lg'])
                </div>
                <h2 class="font-display font-extrabold text-2xl">{{ $recommendedMajor->name }}</h2>
                <p class="text-white/90 text-sm mt-2 max-w-md mx-auto">{{ $recommendedMajor->description }}</p>
            </div>
        @endif

        {{-- Rincian skor semua jurusan --}}
        <div class="bg-white rounded-2xl border border-skblue-100 p-6 mb-8">
            <p class="text-xs font-bold uppercase tracking-wide text-skblue-500 mb-4">Rincian Skor Kecocokan</p>
            <div class="space-y-3">
                @foreach($scores as $slug => $score)
                    @php $major = $majors->firstWhere('slug', $slug); @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-slate-700">{{ $major->code ?? strtoupper($slug) }}</span>
                            <span class="text-skblue-600 font-semibold">{{ round($score * 100, 1) }}%</span>
                        </div>
                        <div class="w-full h-2 bg-skblue-50 rounded-full overflow-hidden">
                            <div class="h-full bg-skblue-500 rounded-full" style="width: {{ $score * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <p class="text-sm text-slate-500 text-center mb-6">
            Rekomendasi ini bersifat saran — Anda tetap bebas memilih jurusan lain di langkah berikutnya.
        </p>

        <a href="{{ route('ppdb.wizard.majorChoice') }}"
           class="block text-center rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
            Lanjut Pilih Jurusan →
        </a>
    </section>

@endsection