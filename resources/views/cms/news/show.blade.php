@extends('layouts.admin')

@section('title', 'Pratinjau Berita')

@section('content')

    <div class="max-w-3xl">
        <div class="flex items-center justify-between mb-5">
            <a href="{{ route('admin.cms.news.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-skblue-600 hover:text-skblue-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke daftar berita
            </a>
            <a href="{{ route('admin.cms.news.edit', $news) }}"
               class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-5 py-2 transition">
                Edit Berita
            </a>
        </div>

        <article class="bg-white rounded-2xl border border-skblue-100 overflow-hidden">
            @if($news->cover_image)
                <img src="{{ asset('storage/'.$news->cover_image) }}" class="w-full h-64 object-cover" alt="{{ $news->title }}">
            @endif

            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    @if($news->status === 'published')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Published
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                        </span>
                    @endif
                    @if($news->category)
                        <span class="text-xs font-medium text-skblue-500">{{ $news->category->name }}</span>
                    @endif
                    <span class="text-xs text-slate-400">
                        {{ optional($news->published_at ?? $news->created_at)->translatedFormat('d F Y') }}
                    </span>
                </div>

                <h1 class="font-display font-extrabold text-2xl md:text-3xl text-slate-800 mb-3">{{ $news->title }}</h1>

                @if($news->excerpt)
                    <p class="text-slate-500 text-sm md:text-base italic border-l-4 border-skblue-200 pl-4 mb-6">{{ $news->excerpt }}</p>
                @endif

                <div class="prose prose-sm md:prose-base max-w-none text-slate-700 leading-relaxed whitespace-pre-line">{{ $news->content }}</div>

                @if($news->author)
                    <p class="text-xs text-slate-400 mt-8 pt-4 border-t border-skblue-50">Ditulis oleh {{ $news->author->name }}</p>
                @endif
            </div>
        </article>
    </div>

@endsection