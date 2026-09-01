@extends('layouts.public')

@section('title', 'Pendaftaran — Upload Dokumen')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 3])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Upload Dokumen Persyaratan</h1>
        <p class="text-sm text-slate-500 mb-6">Langkah 3 dari 7 — format PDF/JPG/PNG, maksimal 4MB per file. Boleh dilewati dulu dan dilengkapi menyusul.</p>

        <form action="{{ route('ppdb.wizard.documents.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                @foreach([
                    ['field' => 'doc_kk', 'label' => 'Kartu Keluarga (KK)'],
                    ['field' => 'doc_akte', 'label' => 'Akte Kelahiran'],
                    ['field' => 'doc_ijazah', 'label' => 'Ijazah / SKL'],
                    ['field' => 'doc_foto', 'label' => 'Pas Foto'],
                ] as $doc)
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">{{ $doc['label'] }}</label>
                        @if(isset($uploaded[$doc['field']]))
                            <p class="text-xs text-green-600 mb-1.5">✓ Sudah diupload: {{ $uploaded[$doc['field']]['name'] }}</p>
                        @endif
                        <input type="file" name="{{ $doc['field'] }}" accept="image/*,.pdf"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-skblue-100 file:text-skblue-700 file:text-xs file:font-semibold hover:file:bg-skblue-200">
                    </div>
                @endforeach
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('ppdb.wizard.parents') }}"
                   class="rounded-xl border border-skblue-200 text-skblue-700 font-semibold px-6 py-3.5 hover:bg-skblue-50 transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="flex-1 rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
                    Lanjut ke Upload Rapor →
                </button>
            </div>
        </form>
    </section>

@endsection