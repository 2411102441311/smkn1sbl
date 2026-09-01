@extends('layouts.admin')

@section('title', 'Berita')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="font-semibold text-skblue-900">Semua Berita ({{ $news->total() }})</h2>
        <a href="{{ route('admin.cms.news.create') }}"
           class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-5 py-2.5 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tulis Berita Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-skblue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-skblue-50 text-skblue-700 text-left">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Judul</th>
                        <th class="px-5 py-3 font-semibold">Kategori</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold">Tanggal</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-skblue-50">
                    @forelse($news as $item)
                        <tr class="hover:bg-skblue-50/50 transition">
                            <td class="px-5 py-3">
                                <p class="font-medium text-slate-700 line-clamp-1 max-w-xs">{{ $item->title }}</p>
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ $item->category?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                @if($item->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-slate-400 text-xs">
                                {{ optional($item->published_at ?? $item->created_at)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.cms.news.edit', $item) }}"
                                       class="w-8 h-8 rounded-lg bg-skblue-50 hover:bg-skblue-100 text-skblue-600 flex items-center justify-center transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.cms.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-sm">
                                Belum ada berita. Klik "Tulis Berita Baru" buat mulai nulis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $news->links() }}
    </div>

@endsection