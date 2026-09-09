@extends('layouts.public')

@section('title', 'Pendaftaran — Biodata')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 1])

    <section class="max-w-3xl mx-auto px-6 py-10">

        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">
            Biodata Calon Siswa
        </h1>

        <p class="text-sm text-slate-500 mb-6">
            Langkah 1 dari 7 — isi data diri calon siswa dengan benar.
        </p>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm px-5 py-4">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form
            action="{{ route('ppdb.wizard.biodata.store') }}"
            method="POST"
            class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8 space-y-4"
        >
            @csrf

            {{-- ========================= --}}
            {{-- NAMA LENGKAP --}}
            {{-- ========================= --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ $old['name'] ?? old('name') }}"
                    required
                    class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                >

                @error('name')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            {{-- ========================= --}}
            {{-- NISN & NIK --}}
            {{-- ========================= --}}
            <div class="grid md:grid-cols-2 gap-4">

                {{-- NISN --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        NISN
                    </label>

                    <input
                        type="text"
                        name="nisn"
                        value="{{ $old['nisn'] ?? old('nisn') }}"
                        maxlength="20"
                        inputmode="numeric"
                        placeholder="Masukkan NISN"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('nisn')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                {{-- NIK --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        value="{{ $old['nik'] ?? old('nik') }}"
                        maxlength="20"
                        inputmode="numeric"
                        placeholder="Masukkan NIK"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('nik')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>


            {{-- ========================= --}}
            {{-- KK & NOMOR HP SISWA --}}
            {{-- ========================= --}}
            <div class="grid md:grid-cols-2 gap-4">

                {{-- NOMOR KK --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Nomor Kartu Keluarga (KK)
                    </label>

                    <input
                        type="text"
                        name="family_card_number"
                        value="{{ $old['family_card_number'] ?? old('family_card_number') }}"
                        maxlength="16"
                        minlength="16"
                        inputmode="numeric"
                        placeholder="Masukkan 16 digit Nomor KK"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('family_card_number')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                {{-- NOMOR HP SISWA --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Nomor HP Siswa
                    </label>

                    <input
                        type="text"
                        name="phone_number"
                        value="{{ $old['phone_number'] ?? old('phone_number') }}"
                        maxlength="30"
                        inputmode="tel"
                        placeholder="Contoh: 081234567890"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('phone_number')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>


            {{-- ========================= --}}
            {{-- JENIS KELAMIN & TEMPAT LAHIR --}}
            {{-- ========================= --}}
            <div class="grid md:grid-cols-2 gap-4">

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Jenis Kelamin
                    </label>

                    <select
                        name="gender"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >
                        <option value="">— Pilih —</option>

                        <option
                            value="L"
                            {{ ($old['gender'] ?? old('gender')) === 'L' ? 'selected' : '' }}
                        >
                            Laki-laki
                        </option>

                        <option
                            value="P"
                            {{ ($old['gender'] ?? old('gender')) === 'P' ? 'selected' : '' }}
                        >
                            Perempuan
                        </option>
                    </select>

                    @error('gender')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                {{-- TEMPAT LAHIR --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Tempat Lahir
                    </label>

                    <input
                        type="text"
                        name="place_of_birth"
                        value="{{ $old['place_of_birth'] ?? old('place_of_birth') }}"
                        placeholder="Masukkan tempat lahir"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('place_of_birth')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>


            {{-- ========================= --}}
            {{-- TANGGAL LAHIR & AGAMA --}}
            {{-- ========================= --}}
            <div class="grid md:grid-cols-2 gap-4">

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        name="date_of_birth"
                        value="{{ $old['date_of_birth'] ?? old('date_of_birth') }}"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('date_of_birth')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                {{-- AGAMA --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Agama
                    </label>

                    <input
                        type="text"
                        name="religion"
                        value="{{ $old['religion'] ?? old('religion') }}"
                        placeholder="Masukkan agama"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('religion')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>


            {{-- ========================= --}}
            {{-- TINGGI & BERAT BADAN --}}
            {{-- ========================= --}}
            <div class="grid md:grid-cols-2 gap-4">

                {{-- TINGGI BADAN --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Tinggi Badan (cm)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        name="height_cm"
                        value="{{ $old['height_cm'] ?? old('height_cm') }}"
                        placeholder="Contoh: 165"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('height_cm')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                {{-- BERAT BADAN --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Berat Badan (kg)
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        name="weight_kg"
                        value="{{ $old['weight_kg'] ?? old('weight_kg') }}"
                        placeholder="Contoh: 55"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('weight_kg')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>


            {{-- ========================= --}}
            {{-- ASAL SEKOLAH --}}
            {{-- ========================= --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1.5">
                    Asal Sekolah (SMP/MTs)
                </label>

                <input
                    type="text"
                    name="school_origin"
                    value="{{ $old['school_origin'] ?? old('school_origin') }}"
                    placeholder="Masukkan asal sekolah"
                    class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                >

                @error('school_origin')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            {{-- ========================= --}}
            {{-- ALAMAT --}}
            {{-- ========================= --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1.5">
                    Alamat Lengkap
                </label>

                <textarea
                    name="address"
                    rows="2"
                    placeholder="Masukkan alamat lengkap"
                    class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                >{{ $old['address'] ?? old('address') }}</textarea>

                @error('address')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            {{-- ========================= --}}
            {{-- KIP --}}
            {{-- ========================= --}}
            <div class="bg-skblue-50 rounded-xl border border-skblue-100 p-4">

                <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 cursor-pointer">

                    <input
                        type="checkbox"
                        id="has_kip"
                        name="has_kip"
                        value="1"
                        {{ old('has_kip', $old['has_kip'] ?? false) ? 'checked' : '' }}
                        onchange="document.getElementById('kip_number_wrap').classList.toggle('hidden', !this.checked)"
                        class="rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400"
                    >

                    Calon siswa memiliki KIP (Kartu Indonesia Pintar)

                </label>


                <div
                    id="kip_number_wrap"
                    class="mt-3 {{ old('has_kip', $old['has_kip'] ?? false) ? '' : 'hidden' }}"
                >

                    <label class="block text-sm font-medium text-slate-600 mb-1.5">
                        Nomor KIP
                    </label>

                    <input
                        type="text"
                        name="kip_number"
                        value="{{ $old['kip_number'] ?? old('kip_number') }}"
                        placeholder="Masukkan Nomor KIP"
                        class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                    >

                    @error('kip_number')
                        <div class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- ========================= --}}
            {{-- BUTTON --}}
            {{-- ========================= --}}
            <button
                type="submit"
                class="w-full rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200"
            >
                Lanjut ke Data Orang Tua →
            </button>

        </form>

    </section>

@endsection