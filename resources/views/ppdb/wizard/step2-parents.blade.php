@extends('layouts.public')

@section('title', 'Pendaftaran — Data Orang Tua')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 2])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Data Orang Tua / Wali</h1>
        <p class="text-sm text-slate-500 mb-6">Langkah 2 dari 7.</p>

        <form action="{{ route('ppdb.wizard.parents.store') }}" method="POST" class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">Ayah</p>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama</label>
                        <input type="text" name="father_name" value="{{ $old['father_name'] ?? '' }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">NIK</label>
                        <input type="text" name="father_nik" value="{{ $old['father_nik'] ?? '' }}" maxlength="20"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">No. HP</label>
                        <input type="text" name="father_phone" value="{{ $old['father_phone'] ?? '' }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Pekerjaan</label>
                        <input type="text" name="father_occupation" value="{{ $old['father_occupation'] ?? '' }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">Ibu</p>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama</label>
                        <input type="text" name="mother_name" value="{{ $old['mother_name'] ?? '' }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">NIK</label>
                        <input type="text" name="mother_nik" value="{{ $old['mother_nik'] ?? '' }}" maxlength="20"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">No. HP</label>
                        <input type="text" name="mother_phone" value="{{ $old['mother_phone'] ?? '' }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Pekerjaan</label>
                        <input type="text" name="mother_occupation" value="{{ $old['mother_occupation'] ?? '' }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('ppdb.wizard.biodata') }}"
                   class="rounded-xl border border-skblue-200 text-skblue-700 font-semibold px-6 py-3.5 hover:bg-skblue-50 transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="flex-1 rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
                    Lanjut ke Upload Dokumen →
                </button>
            </div>
        </form>
    </section>

@endsection