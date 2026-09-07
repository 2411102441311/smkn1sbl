@extends('layouts.admin')

@section('title', 'Pengaturan Situs')

@section('content')

    <div class="max-w-3xl">
        <p class="text-sm text-slate-500 mb-6">
            Data di halaman ini dipakai otomatis di berbagai bagian web (navbar, footer, dll) —
            ubah di sini, gak perlu edit kode atau lewat terminal lagi.
        </p>

        <form action="{{ route('admin.cms.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @foreach($groupedFields as $groupName => $fields)
                <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
                    <h3 class="font-display font-bold text-skblue-900 text-lg mb-5">{{ $groupName }}</h3>

                    <div class="space-y-4">
                        @foreach($fields as $field)
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">{{ $field['label'] }}</label>

                                @if($field['type'] === 'textarea')
                                    <textarea name="settings[{{ $field['key'] }}]" rows="3"
                                              class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">{{ old('settings.'.$field['key'], $field['value']) }}</textarea>
                                @else
                                    <input type="text" name="settings[{{ $field['key'] }}]"
                                           value="{{ old('settings.'.$field['key'], $field['value']) }}"
                                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                                @endif

                                @if($field['key'] === 'principal_photo')
                                    <p class="text-xs text-slate-400 mt-1">
                                        Upload dulu foto ke folder <code class="bg-slate-100 px-1 rounded">public/images/</code> lewat VS Code,
                                        baru ketik nama file-nya di sini (contoh: <code class="bg-slate-100 px-1 rounded">kepala-sekolah.jpg</code>).
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit"
                    class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                Simpan Semua Pengaturan
            </button>
        </form>
    </div>

@endsection