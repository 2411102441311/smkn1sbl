@extends('layouts.admin')

@section('title', 'Perbaiki Pendaftar')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            <div class="mb-6">
                <a href="{{ route('admin.ppdb.applicants.index') }}" class="text-sm font-semibold text-skblue-600 hover:text-skblue-800">Kembali ke Pendaftar</a>
                <h2 class="font-semibold text-skblue-900 mt-3">Perbaiki Data Pendaftar</h2>
                <p class="text-sm text-slate-500 mt-1">Perbaiki data yang ditolak, lalu ajukan ulang untuk verifikasi.</p>
            </div>

            <form action="{{ route('admin.ppdb.applicants.update', $registration) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Nomor Pendaftaran</label>
                    <input type="text" value="{{ $registration->registration_number }}" disabled
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-500">
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" required value="{{ old('name', $registration->biodata?->name) }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="school_origin" class="block text-sm font-medium text-slate-600 mb-1">Asal Sekolah</label>
                    <input id="school_origin" type="text" name="school_origin" value="{{ old('school_origin', $registration->biodata?->school_origin) }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    @error('school_origin') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-600 mb-1">Alamat</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">{{ old('address', $registration->biodata?->address) }}</textarea>
                    @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="father_phone" class="block text-sm font-medium text-slate-600 mb-1">No. HP Ayah</label>
                        <input id="father_phone" type="text" name="father_phone" value="{{ old('father_phone', $registration->parentData?->father_phone) }}"
                               class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                    <div>
                        <label for="mother_phone" class="block text-sm font-medium text-slate-600 mb-1">No. HP Ibu</label>
                        <input id="mother_phone" type="text" name="mother_phone" value="{{ old('mother_phone', $registration->parentData?->mother_phone) }}"
                               class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label for="major_id" class="block text-sm font-medium text-slate-600 mb-1">Jurusan Pilihan</label>
                    <select id="major_id" name="major_id" required
                            class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" @selected(old('major_id', $registration->majorChoices->first()?->major_id) == $major->id)>
                                {{ $major->code }} — {{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('major_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                    Simpan & Ajukan Ulang
                </button>
            </form>
        </div>
    </div>
@endsection
