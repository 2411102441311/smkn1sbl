@extends('layouts.public')

@section('title', 'Pendaftaran — Upload Rapor')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 4])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Upload Foto Rapor</h1>
        <p class="text-sm text-slate-500 mb-6">Langkah 4 dari 7 — sistem akan membaca nilai rapor Anda secara otomatis.</p>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm px-5 py-4">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-skblue-50 rounded-2xl border border-skblue-100 p-6 md:p-8">
            <div class="flex items-start gap-3 mb-6 bg-white rounded-xl p-4 border border-skblue-100">
                <svg class="w-5 h-5 text-skblue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Tips supaya nilai terbaca akurat: foto dengan pencahayaan cukup, kamera tegak lurus (tidak miring),
                    dan halaman nilai rapor terlihat jelas & tidak buram. Anda tetap bisa mengoreksi hasilnya di langkah berikutnya.
                </p>
            </div>

            <form action="{{ route('ppdb.wizard.reportCard.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="block text-sm font-medium text-slate-600 mb-1.5">
                    Foto Rapor <span class="text-red-500">*</span>
                    <span class="font-normal text-slate-400">(boleh pilih lebih dari 1 foto sekaligus, misal per semester)</span>
                </label>
                <input type="file" name="report_cards[]" accept="image/*" multiple required
                       class="w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-skblue-600 file:text-white file:text-sm file:font-semibold hover:file:bg-skblue-700">
                <p class="text-xs text-slate-400 mt-2">
                    Tekan <kbd class="bg-white border border-slate-200 rounded px-1.5 py-0.5 text-[10px]">Ctrl</kbd>
                    sambil klik buat pilih beberapa foto sekaligus (Windows), atau
                    <kbd class="bg-white border border-slate-200 rounded px-1.5 py-0.5 text-[10px]">Cmd</kbd> di Mac.
                </p>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('ppdb.wizard.documents') }}"
                       class="rounded-xl border border-skblue-200 text-skblue-700 font-semibold px-6 py-3.5 hover:bg-white transition bg-white">
                        ← Kembali
                    </a>
                    <button type="submit"
                            class="flex-1 rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
                        Baca Nilai Otomatis →
                    </button>
                </div>
            </form>
        </div>
    </section>

@endsection