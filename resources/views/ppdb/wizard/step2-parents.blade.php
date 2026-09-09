@extends('layouts.public')

@section('title', 'Pendaftaran — Data Orang Tua')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 2])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">
            Data Orang Tua / Wali
        </h1>

        <p class="text-sm text-slate-500 mb-6">
            Langkah 2 dari 7.
        </p>

        <form
            action="{{ route('ppdb.wizard.parents.store') }}"
            method="POST"
            class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8"
        >
            @csrf

            {{-- ===================================================== --}}
            {{-- DATA AYAH & IBU --}}
            {{-- ===================================================== --}}

            <div class="grid md:grid-cols-2 gap-6">

                {{-- ==================== AYAH ==================== --}}
                <div class="space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">
                        Ayah
                    </p>

                    {{-- Nama Ayah --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="father_name"
                            value="{{ $old['father_name'] ?? old('father_name') }}"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                    {{-- NIK Ayah --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            NIK
                        </label>

                        <input
                            type="text"
                            name="father_nik"
                            value="{{ $old['father_nik'] ?? old('father_nik') }}"
                            maxlength="20"
                            inputmode="numeric"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                    {{-- HP Ayah --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            No. HP
                        </label>

                        <input
                            type="text"
                            name="father_phone"
                            value="{{ $old['father_phone'] ?? old('father_phone') }}"
                            inputmode="tel"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                    {{-- Pekerjaan Ayah --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Pekerjaan
                        </label>

                        <input
                            type="text"
                            name="father_occupation"
                            value="{{ $old['father_occupation'] ?? old('father_occupation') }}"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>
                </div>


                {{-- ==================== IBU ==================== --}}
                <div class="space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">
                        Ibu
                    </p>

                    {{-- Nama Ibu --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="mother_name"
                            value="{{ $old['mother_name'] ?? old('mother_name') }}"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                    {{-- NIK Ibu --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            NIK
                        </label>

                        <input
                            type="text"
                            name="mother_nik"
                            value="{{ $old['mother_nik'] ?? old('mother_nik') }}"
                            maxlength="20"
                            inputmode="numeric"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                    {{-- HP Ibu --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            No. HP
                        </label>

                        <input
                            type="text"
                            name="mother_phone"
                            value="{{ $old['mother_phone'] ?? old('mother_phone') }}"
                            inputmode="tel"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                    {{-- Pekerjaan Ibu --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Pekerjaan
                        </label>

                        <input
                            type="text"
                            name="mother_occupation"
                            value="{{ $old['mother_occupation'] ?? old('mother_occupation') }}"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>
                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- CHECKBOX WALI --}}
            {{-- ===================================================== --}}

            <div class="mt-8 rounded-2xl bg-skblue-50 border border-skblue-100 p-4">

                <label class="flex items-start gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        id="has_guardian"
                        name="has_guardian"
                        value="1"
                        {{ old('has_guardian', $old['has_guardian'] ?? false) ? 'checked' : '' }}
                        onchange="toggleGuardian()"
                        class="mt-1 rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400"
                    >

                    <div>
                        <span class="block text-sm font-semibold text-slate-700">
                            Memiliki Wali
                        </span>

                        <span class="block text-xs text-slate-500 mt-0.5">
                            Centang jika calon siswa memiliki wali selain ayah dan ibu.
                        </span>
                    </div>

                </label>

            </div>


            {{-- ===================================================== --}}
            {{-- FORM DATA WALI --}}
            {{-- ===================================================== --}}

            <div
                id="guardian-form"
                class="mt-6 rounded-2xl border border-skblue-100 bg-white p-5 md:p-6
                {{ old('has_guardian', $old['has_guardian'] ?? false) ? '' : 'hidden' }}"
            >

                <div class="mb-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">
                        Data Wali
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Isi data wali yang bertanggung jawab terhadap calon siswa.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-4">

                    {{-- Hubungan Wali --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Hubungan dengan Calon Siswa
                        </label>

                        <select
                            name="guardian_relationship"
                            id="guardian_relationship"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                            <option value="">— Pilih Hubungan —</option>

                            <option
                                value="Kakek"
                                {{ ($old['guardian_relationship'] ?? old('guardian_relationship')) === 'Kakek' ? 'selected' : '' }}
                            >
                                Kakek
                            </option>

                            <option
                                value="Nenek"
                                {{ ($old['guardian_relationship'] ?? old('guardian_relationship')) === 'Nenek' ? 'selected' : '' }}
                            >
                                Nenek
                            </option>

                            <option
                                value="Paman"
                                {{ ($old['guardian_relationship'] ?? old('guardian_relationship')) === 'Paman' ? 'selected' : '' }}
                            >
                                Paman
                            </option>

                            <option
                                value="Bibi"
                                {{ ($old['guardian_relationship'] ?? old('guardian_relationship')) === 'Bibi' ? 'selected' : '' }}
                            >
                                Bibi
                            </option>

                            <option
                                value="Kakak"
                                {{ ($old['guardian_relationship'] ?? old('guardian_relationship')) === 'Kakak' ? 'selected' : '' }}
                            >
                                Kakak
                            </option>

                            <option
                                value="Wali Lainnya"
                                {{ ($old['guardian_relationship'] ?? old('guardian_relationship')) === 'Wali Lainnya' ? 'selected' : '' }}
                            >
                                Wali Lainnya
                            </option>
                        </select>
                    </div>


                    {{-- Nama Wali --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Nama Wali
                        </label>

                        <input
                            type="text"
                            name="guardian_name"
                            id="guardian_name"
                            value="{{ $old['guardian_name'] ?? old('guardian_name') }}"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>


                    {{-- NIK Wali --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            NIK Wali
                        </label>

                        <input
                            type="text"
                            name="guardian_nik"
                            id="guardian_nik"
                            value="{{ $old['guardian_nik'] ?? old('guardian_nik') }}"
                            maxlength="20"
                            inputmode="numeric"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>


                    {{-- No HP Wali --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            No. HP Wali
                        </label>

                        <input
                            type="text"
                            name="guardian_phone"
                            id="guardian_phone"
                            value="{{ $old['guardian_phone'] ?? old('guardian_phone') }}"
                            inputmode="tel"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>


                    {{-- Pekerjaan Wali --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Pekerjaan Wali
                        </label>

                        <input
                            type="text"
                            name="guardian_occupation"
                            id="guardian_occupation"
                            value="{{ $old['guardian_occupation'] ?? old('guardian_occupation') }}"
                            class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                        >
                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- BUTTON --}}
            {{-- ===================================================== --}}

            <div class="flex gap-3 mt-8">

                <a
                    href="{{ route('ppdb.wizard.biodata') }}"
                    class="rounded-xl border border-skblue-200 text-skblue-700 font-semibold px-6 py-3.5 hover:bg-skblue-50 transition"
                >
                    ← Kembali
                </a>

                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200"
                >
                    Lanjut ke Upload Dokumen →
                </button>

            </div>

        </form>
    </section>


    {{-- ===================================================== --}}
    {{-- JAVASCRIPT CHECKBOX WALI --}}
    {{-- ===================================================== --}}

    <script>
        function toggleGuardian() {
            const checkbox = document.getElementById('has_guardian');
            const guardianForm = document.getElementById('guardian-form');

            if (checkbox.checked) {
                guardianForm.classList.remove('hidden');
            } else {
                guardianForm.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleGuardian();
        });
    </script>

@endsection