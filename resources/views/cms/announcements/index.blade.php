@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- ============ FORM TAMBAH PENGUMUMAN ============ --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-skblue-100 p-6 sticky top-24">
                <h3 class="font-display font-bold text-skblue-900 mb-4">Tambah Pengumuman</h3>

                <form action="{{ route('admin.cms.announcements.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Judul</label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                               class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                               placeholder="Contoh: Libur Hari Raya Idul Fitri">
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Isi Pengumuman</label>
                        <textarea name="body" rows="3" required
                                  class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                                  placeholder="Tulis detail singkat pengumumannya">{{ old('body') }}</textarea>
                        @error('body') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Mulai Tampil</label>
                            <input type="date" name="start_date" required value="{{ old('start_date', now()->toDateString()) }}"
                                   class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            @error('start_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Sampai (opsional)</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            @error('end_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 -mt-2">Kosongkan "Sampai" kalau pengumuman berlaku terus tanpa batas waktu.</p>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}
                               class="rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400">
                        Sematkan di urutan paling atas
                    </label>

                    <button type="submit"
                            class="w-full rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                        Simpan Pengumuman
                    </button>
                </form>
            </div>
        </div>

        {{-- ============ DAFTAR PENGUMUMAN ============ --}}
        <div class="lg:col-span-2 space-y-4">
            <h2 class="font-semibold text-skblue-900">Semua Pengumuman ({{ $announcements->total() }})</h2>

            @forelse($announcements as $item)
                @php
                    $isActive = $item->start_date <= now()->toDateString() && (!$item->end_date || $item->end_date >= now()->toDateString());
                @endphp
                <div class="bg-white rounded-2xl border border-skblue-100 p-5">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($item->is_pinned)
                                <span class="inline-flex items-center gap-1 rounded-full bg-skgold-500/10 text-skgold-600 text-xs font-semibold px-2.5 py-1">
                                    <i class="fa-solid fa-thumbtack text-[10px]"></i> Disematkan
                                </span>
                            @endif
                            @if($isActive)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sedang Tampil
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-semibold px-2.5 py-1">
                                    Belum/Sudah Lewat
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" onclick="document.getElementById('edit-{{ $item->id }}').classList.toggle('hidden')"
                                    class="w-8 h-8 rounded-lg bg-skblue-50 hover:bg-skblue-100 text-skblue-600 flex items-center justify-center transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.cms.announcements.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h4 class="font-display font-semibold text-slate-800">{{ $item->title }}</h4>
                    <p class="text-sm text-slate-500 mt-1">{{ $item->body }}</p>
                    <p class="text-xs text-slate-400 mt-2">
                        {{ $item->start_date->translatedFormat('d M Y') }}
                        @if($item->end_date) &ndash; {{ $item->end_date->translatedFormat('d M Y') }} @endif
                    </p>

                    {{-- Form edit, disembunyikan default, muncul kalau tombol edit diklik --}}
                    <div id="edit-{{ $item->id }}" class="hidden mt-4 pt-4 border-t border-skblue-50">
                        <form action="{{ route('admin.cms.announcements.update', $item) }}" method="POST" class="space-y-3">
                            @csrf @method('PUT')
                            <input type="text" name="title" value="{{ $item->title }}" required
                                   class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            <textarea name="body" rows="2" required
                                      class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">{{ $item->body }}</textarea>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="date" name="start_date" value="{{ $item->start_date->toDateString() }}" required
                                       class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                                <input type="date" name="end_date" value="{{ $item->end_date?->toDateString() }}"
                                       class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            </div>
                            <label class="flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" name="is_pinned" value="1" {{ $item->is_pinned ? 'checked' : '' }}
                                       class="rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400">
                                Sematkan di urutan paling atas
                            </label>
                            <button type="submit" class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-xs font-semibold px-5 py-2 transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-skblue-100 p-8 text-center text-slate-400 text-sm">
                    Belum ada pengumuman. Isi form di samping buat bikin yang pertama.
                </div>
            @endforelse

            <div class="mt-4">{{ $announcements->links() }}</div>
        </div>
    </div>

@endsection