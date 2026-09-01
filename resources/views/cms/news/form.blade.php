@extends('layouts.admin')

@section('title', isset($news) ? 'Edit Berita' : 'Tulis Berita Baru')

@section('content')

    <div class="max-w-3xl">
        <a href="{{ route('admin.cms.news.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-skblue-600 hover:text-skblue-800 transition mb-5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke daftar berita
        </a>

        <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            <form action="{{ isset($news) ? route('admin.cms.news.update', $news) : route('admin.cms.news.store') }}"
                  method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @if(isset($news)) @method('PUT') @endif

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Judul Berita</label>
                    <input type="text" name="title" required value="{{ old('title', $news->title ?? '') }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                           placeholder="Contoh: Tim Robotik Raih Juara 1 Tingkat Provinsi">
                    @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Kategori (opsional)</label>
                        <select name="category_id" class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            <option value="">— Tanpa kategori —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $news->category_id ?? null) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                        <select name="status" required class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            <option value="draft" @selected(old('status', $news->status ?? 'draft') === 'draft')>Draft (belum tayang)</option>
                            <option value="published" @selected(old('status', $news->status ?? 'draft') === 'published')>Published (langsung tayang)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Ringkasan (excerpt)</label>
                    <textarea name="excerpt" rows="2"
                              class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                              placeholder="1-2 kalimat ringkasan, muncul di kartu berita halaman depan">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
                    @error('excerpt') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Isi Berita</label>
                    <textarea name="content" rows="10" required
                              class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                              placeholder="Tulis isi lengkap beritanya di sini...">{{ old('content', $news->content ?? '') }}</textarea>
                    @error('content') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Foto Sampul (opsional)</label>
                    @if(!empty($news?->cover_image))
                        <img src="{{ asset('storage/'.$news->cover_image) }}" class="w-full max-w-xs h-32 object-cover rounded-lg mb-2 border border-skblue-100">
                        <p class="text-xs text-slate-400 mb-2">Foto di atas sudah kepasang. Upload foto baru kalau mau ganti.</p>
                    @endif
                    <input type="file" name="cover_image" accept="image/*"
                           class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-skblue-600 file:text-white file:text-sm file:font-semibold hover:file:bg-skblue-700">
                    <p class="text-xs text-slate-400 mt-1">Format JPG/PNG, maksimal 2MB.</p>
                    @error('cover_image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                        {{ isset($news) ? 'Simpan Perubahan' : 'Publikasikan' }}
                    </button>
                    <a href="{{ route('admin.cms.news.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection