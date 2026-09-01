@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')

    {{-- Form upload foto baru --}}
    <div class="bg-white rounded-2xl border border-skblue-100 p-6 mb-8">
        <h2 class="font-semibold text-skblue-900 mb-4">Tambah Foto Baru</h2>

        <form action="{{ route('admin.cms.gallery.store') }}" method="POST" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Judul Foto</label>
                <input type="text" name="title" required
                       class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                       placeholder="Contoh: Lomba Kompetensi Siswa 2026">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Kategori (opsional)</label>
                <select name="category_id" class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    <option value="">— Tanpa kategori —</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-1">File Foto</label>
                <input type="file" name="image" accept="image/*" required
                       class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-skblue-600 file:text-white file:text-sm file:font-semibold hover:file:bg-skblue-700">
                <p class="text-xs text-slate-400 mt-1">Format JPG/PNG, maksimal 4MB.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-1">Keterangan (opsional)</label>
                <textarea name="caption" rows="2"
                          class="w-full rounded-lg border border-skblue-200 px-3 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                          placeholder="Keterangan singkat foto"></textarea>
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                        class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                    Unggah Foto
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar foto yang sudah ada --}}
    <div class="bg-white rounded-2xl border border-skblue-100 p-6">
        <h2 class="font-semibold text-skblue-900 mb-4">Semua Foto ({{ $galleries->total() }})</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($galleries as $item)
                <div class="group relative rounded-xl overflow-hidden border border-skblue-100">
                    <img src="{{ url('storage/'.$item->image_path) }}" class="w-full h-40 object-cover" alt="{{ $item->title }}">
                    <div class="p-3">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $item->title }}</p>
                        @if($item->category)
                            <p class="text-xs text-skblue-500">{{ $item->category->name }}</p>
                        @endif
                    </div>
                    <form action="{{ route('admin.cms.gallery.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus foto ini?')"
                          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center text-xs">
                            ✕
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-slate-400 col-span-full">Belum ada foto yang diunggah.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $galleries->links() }}
        </div>
    </div>

@endsection