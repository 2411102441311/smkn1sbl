@extends('layouts.public')

@section('title', 'Pendaftaran PPDB — ' . \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu'))

@section('content')

    {{-- ============ PAGE HEADER ============ --}}
    <section class="bg-gradient-to-br from-skblue-700 to-skblue-500 py-16 md:py-20">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <p class="inline-block text-xs font-bold tracking-widest uppercase text-white/90 bg-white/15 border border-white/25 rounded-full px-4 py-1.5 backdrop-blur-sm mb-5">
                Penerimaan Peserta Didik Baru
            </p>
            <h1 class="font-display font-extrabold text-white text-3xl md:text-4xl">Formulir Pendaftaran</h1>
            <p class="text-white/90 mt-3">Lengkapi data di bawah ini dengan benar. Simpan nomor pendaftaran setelah selesai.</p>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-6 py-14">

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm px-5 py-4">
                <p class="font-semibold mb-1">Ada beberapa isian yang perlu diperbaiki:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ppdb.applicants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- ============ BIODATA SISWA ============ --}}
            <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
                <h2 class="font-display font-bold text-lg text-skblue-900 mb-5 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-skblue-600 text-white text-sm flex items-center justify-center shrink-0">1</span>
                    Biodata Calon Siswa
                </h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="20"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Jenis Kelamin</label>
                        <select name="gender" class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            <option value="">— Pilih —</option>
                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Tempat Lahir</label>
                        <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Agama</label>
                        <input type="text" name="religion" value="{{ old('religion') }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Asal Sekolah (SMP/MTs)</label>
                        <input type="text" name="school_origin" value="{{ old('school_origin') }}"
                               class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Alamat Lengkap</label>
                        <textarea name="address" rows="2"
                                  class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ============ DATA ORANG TUA ============ --}}
            <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
                <h2 class="font-display font-bold text-lg text-skblue-900 mb-5 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-skblue-600 text-white text-sm flex items-center justify-center shrink-0">2</span>
                    Data Orang Tua / Wali
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">Ayah</p>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama</label>
                            <input type="text" name="father_name" value="{{ old('father_name') }}"
                                   class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">No. HP</label>
                            <input type="text" name="father_phone" value="{{ old('father_phone') }}"
                                   class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Pekerjaan</label>
                            <input type="text" name="father_occupation" value="{{ old('father_occupation') }}"
                                   class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-skblue-500">Ibu</p>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama</label>
                            <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                   class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">No. HP</label>
                            <input type="text" name="mother_phone" value="{{ old('mother_phone') }}"
                                   class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Pekerjaan</label>
                            <input type="text" name="mother_occupation" value="{{ old('mother_occupation') }}"
                                   class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============ PILIHAN JURUSAN ============ --}}
            <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
                <h2 class="font-display font-bold text-lg text-skblue-900 mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-skblue-600 text-white text-sm flex items-center justify-center shrink-0">3</span>
                    Pilihan Jurusan
                </h2>
                <p class="text-sm text-slate-500 mb-5">Urutkan sesuai prioritas. Pilihan 1 wajib diisi.</p>

                <div class="grid md:grid-cols-3 gap-4">
                    @foreach([1, 2, 3] as $order)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">
                                Pilihan {{ $order }} {{ $order === 1 ? '*' : '(opsional)' }}
                            </label>
                            <select name="major_choice_{{ $order }}" {{ $order === 1 ? 'required' : '' }}
                                    class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                                <option value="">— Pilih Jurusan —</option>
                                @foreach($majors as $major)
                                    <option value="{{ $major->id }}" {{ old("major_choice_{$order}") == $major->id ? 'selected' : '' }}>
                                        {{ $major->code }} — {{ $major->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ============ UPLOAD BERKAS ============ --}}
            <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
                <h2 class="font-display font-bold text-lg text-skblue-900 mb-5 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-skblue-600 text-white text-sm flex items-center justify-center shrink-0">4</span>
                    Upload Berkas
                </h2>

                <div class="grid md:grid-cols-2 gap-4">
                    @foreach([
                        ['field' => 'doc_kk', 'label' => 'Kartu Keluarga (KK)'],
                        ['field' => 'doc_akte', 'label' => 'Akte Kelahiran'],
                        ['field' => 'doc_ijazah', 'label' => 'Ijazah / SKL'],
                        ['field' => 'doc_foto', 'label' => 'Pas Foto'],
                    ] as $doc)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">{{ $doc['label'] }}</label>
                            <input type="file" name="{{ $doc['field'] }}" accept="image/*,.pdf"
                                   class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-skblue-100 file:text-skblue-700 file:text-xs file:font-semibold hover:file:bg-skblue-200">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ============ UPLOAD RAPOR (OCR) ============ --}}
            <div class="bg-skblue-50 rounded-2xl border border-skblue-100 p-6 md:p-8">
                <h2 class="font-display font-bold text-lg text-skblue-900 mb-2 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-skblue-600 text-white text-sm flex items-center justify-center shrink-0">5</span>
                    Foto Rapor
                </h2>
                <p class="text-sm text-slate-500 mb-4">
                    Sistem akan membaca nilai rapor secara otomatis. Pastikan foto jelas, tidak buram, dan pencahayaan cukup.
                    Nilai hasil pembacaan akan bisa Anda periksa & koreksi setelah pendaftaran.
                </p>
                <input type="file" name="report_card" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-skblue-600 file:text-white file:text-xs file:font-semibold hover:file:bg-skblue-700">
            </div>

            {{-- ============ SUBMIT ============ --}}
            <button type="submit"
                    class="w-full rounded-2xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-4 shadow-md transition-all duration-200">
                Kirim Pendaftaran
            </button>
        </form>
    </section>

@endsection