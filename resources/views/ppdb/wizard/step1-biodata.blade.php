@extends('layouts.public')

@section('title', 'Pendaftaran — Biodata')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 1])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Biodata Calon Siswa</h1>
        <p class="text-sm text-slate-500 mb-6">Langkah 1 dari 7 — isi data diri calon siswa dengan benar.</p>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm px-5 py-4">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ppdb.wizard.biodata.store') }}" method="POST" class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ $old['name'] ?? old('name') }}" required
                       class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">NIK</label>
                    <input type="text" name="nik" value="{{ $old['nik'] ?? old('nik') }}" maxlength="20"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Nomor Kartu Keluarga (KK)</label>
                    <input type="text" name="family_card_number" value="{{ $old['family_card_number'] ?? old('family_card_number') }}" maxlength="20"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Jenis Kelamin</label>
                    <select name="gender" class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        <option value="">— Pilih —</option>
                        <option value="L" {{ ($old['gender'] ?? old('gender')) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ ($old['gender'] ?? old('gender')) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Tempat Lahir</label>
                    <input type="text" name="place_of_birth" value="{{ $old['place_of_birth'] ?? old('place_of_birth') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" value="{{ $old['date_of_birth'] ?? old('date_of_birth') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Agama</label>
                    <input type="text" name="religion" value="{{ $old['religion'] ?? old('religion') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="height_cm" value="{{ $old['height_cm'] ?? old('height_cm') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="weight_kg" value="{{ $old['weight_kg'] ?? old('weight_kg') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Asal Sekolah (SMP/MTs)</label>
                    <input type="text" name="school_origin" value="{{ $old['school_origin'] ?? old('school_origin') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1.5">Alamat Lengkap</label>
                <textarea name="address" rows="2"
                          class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">{{ $old['address'] ?? old('address') }}</textarea>
            </div>

            {{-- KIP --}}
            <div class="bg-skblue-50 rounded-xl border border-skblue-100 p-4">
                <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" id="has_kip" name="has_kip" value="1"
                           {{ old('has_kip', $old['has_kip'] ?? false) ? 'checked' : '' }}
                           onchange="document.getElementById('kip_number_wrap').classList.toggle('hidden', !this.checked)"
                           class="rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400">
                    Calon siswa memiliki KIP (Kartu Indonesia Pintar)
                </label>
                <div id="kip_number_wrap" class="mt-3 {{ old('has_kip', $old['has_kip'] ?? false) ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Nomor KIP</label>
                    <input type="text" name="kip_number" value="{{ $old['kip_number'] ?? old('kip_number') }}"
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                </div>
            </div>

            <button type="submit"
                    class="w-full rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
                Lanjut ke Data Orang Tua →
            </button>
        </form>
    </section>

@endsection