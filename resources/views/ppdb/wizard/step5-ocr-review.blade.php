@extends('layouts.public')

@section('title', 'Pendaftaran — Konfirmasi Nilai')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 5])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Konfirmasi Nilai Rapor</h1>
        <p class="text-sm text-slate-500 mb-1">Langkah 5 dari 7 — sistem sudah membaca nilai dari foto rapor Anda.</p>

        @if($confidence < 60)
            <div class="mt-3 mb-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs px-4 py-3">
                ⚠ Tingkat keyakinan pembacaan cukup rendah ({{ $confidence }}%). Mohon periksa & koreksi nilai di bawah dengan teliti.
            </div>
        @else
            <p class="text-xs text-green-600 mb-4">✓ Tingkat keyakinan pembacaan: {{ $confidence }}%</p>
        @endif

        <form action="{{ route('ppdb.wizard.ocrReview.store') }}" method="POST" class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8 mt-4">
            @csrf

            <p class="text-sm text-slate-500 mb-5">Periksa nilai di bawah ini. Perbaiki kalau ada yang salah baca oleh sistem.</p>

            <div class="space-y-4">
                @foreach($subjects as $subject)
                    <div class="flex items-center justify-between gap-4">
                        <label class="text-sm font-medium text-slate-600 flex-1">{{ $subject }}</label>
                        <input type="number" name="grades[{{ $subject }}]" min="0" max="100" step="0.01"
                               value="{{ $grades[$subject] ?? '' }}"
                               placeholder="Belum terbaca"
                               class="w-32 rounded-xl border border-skblue-200 px-4 py-2.5 text-sm text-center focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                @endforeach
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('ppdb.wizard.reportCard') }}"
                   class="rounded-xl border border-skblue-200 text-skblue-700 font-semibold px-6 py-3.5 hover:bg-skblue-50 transition">
                    ← Upload Ulang Foto
                </a>
                <button type="submit"
                        class="flex-1 rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
                    Konfirmasi & Lihat Rekomendasi →
                </button>
            </div>
        </form>
    </section>

@endsection