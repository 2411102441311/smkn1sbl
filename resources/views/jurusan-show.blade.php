@extends('layouts.public')

@section('title', $major['name'] . ' — ' . ($schoolName ?? 'SMK Negeri 1 Sebulu'))

@section('content')

    {{-- ============ PAGE HEADER ============ --}}
    <section class="relative isolate">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="w-full h-full bg-gradient-to-br {{ $major['color_from'] }} {{ $major['color_to'] }}"></div>
            <div class="absolute inset-0 bg-black/10"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 py-16 md:py-20">
            <nav class="flex items-center gap-2 text-xs md:text-sm text-white/80 mb-6 reveal">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <span>/</span>
                <a href="{{ route('home') }}#jurusan" class="hover:text-white transition">Jurusan</a>
                <span>/</span>
                <span class="text-white font-medium">{{ $major['name'] }}</span>
            </nav>

            <div class="flex items-start gap-5 reveal">
                <div class="shrink-0 [&>div]:!bg-white/95 [&>div]:!border-white/40">
                    @include('partials.major-badge', ['major' => $major, 'size' => 'lg'])
                </div>
                <div>
                    <p class="inline-block text-xs font-bold tracking-widest uppercase text-white/90 bg-white/15 border border-white/25 rounded-full px-4 py-1.5 backdrop-blur-sm mb-5">
                        Spek. {{ $major['code'] }}
                    </p>
                    <h1 class="font-display font-extrabold text-white text-3xl md:text-5xl max-w-2xl leading-tight">
                        {{ $major['name'] }}
                    </h1>
                    <p class="text-white/90 max-w-xl mt-4">
                        {{ $major['desc'] }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ KONTEN UTAMA ============ --}}
    <section class="max-w-7xl mx-auto px-6 py-16 md:py-20">
        <div class="grid lg:grid-cols-3 gap-12">

            {{-- Kiri: deskripsi + galeri --}}
            <div class="lg:col-span-2 space-y-12">
                <div class="reveal">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $major['color_from'] }} {{ $major['color_to'] }} flex items-center justify-center shrink-0">
                            @include('partials.major-icon', ['icon' => $major['icon'], 'class' => 'w-5 h-5 text-white'])
                        </div>
                        <h2 class="font-display font-bold text-2xl text-slate-800">Tentang Program Ini</h2>
                    </div>
                    <div class="text-slate-600 leading-relaxed space-y-4">
                        @foreach(explode("\n\n", $major['description']) as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>

                {{-- Galeri jurusan --}}
                <div class="reveal">
                    <h3 class="font-display font-bold text-xl text-slate-800 mb-5">Galeri Kegiatan</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @php
                            $galleryPath = "images/jurusan/{$major['slug']}";
                        @endphp
                        @for($i = 1; $i <= 6; $i++)
                            @php $imgFile = public_path("{$galleryPath}/{$i}.jpg"); @endphp
                            <div class="rounded-2xl overflow-hidden h-32 sm:h-36 bg-skblue-100 reveal-zoom">
                                @if(file_exists($imgFile))
                                    <img src="{{ asset("{$galleryPath}/{$i}.jpg") }}" class="w-full h-full object-cover hover:scale-105 transition duration-300" alt="Galeri {{ $major['name'] }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-skblue-300 text-xs text-center px-2">
                                        Foto {{ $i }} belum diunggah
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-400 mt-3">
                        * Taruh foto kegiatan jurusan ini di folder <code class="bg-slate-100 px-1.5 py-0.5 rounded">public/{{ $galleryPath }}/</code> dengan nama <code class="bg-slate-100 px-1.5 py-0.5 rounded">1.jpg</code> sampai <code class="bg-slate-100 px-1.5 py-0.5 rounded">6.jpg</code>.
                    </p>
                </div>
            </div>

            {{-- Kanan: fasilitas, prospek karier, CTA --}}
            <div class="space-y-6">
                <div class="bg-skblue-50 border border-skblue-100 rounded-2xl p-6 reveal-right">
                    <h3 class="font-display font-bold text-skblue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-skblue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m9-13h.01M9 8h.01M9 12h.01M12 12h.01M9 16h.01M12 16h.01M15 12h.01M15 16h.01"/>
                        </svg>
                        Fasilitas Jurusan
                    </h3>
                    <ul class="space-y-3">
                        @foreach($major['facilities'] as $facility)
                            <li class="flex items-start gap-2.5 text-sm text-slate-600">
                                <span class="shrink-0 w-1.5 h-1.5 rounded-full bg-skblue-500 mt-1.5"></span>
                                {{ $facility }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white border border-skblue-100 rounded-2xl p-6 reveal-right">
                    <h3 class="font-display font-bold text-skblue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-skblue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/>
                        </svg>
                        Prospek Karier
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($major['careers'] as $career)
                            <span class="text-xs font-medium text-skblue-700 bg-skblue-50 border border-skblue-100 rounded-full px-3 py-1.5">
                                {{ $career }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('ppdb.applicants.create') }}"
                   class="block text-center bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold rounded-2xl px-6 py-4 shadow-soft transition-all duration-200 reveal-right">
                    Daftar ke Jurusan Ini
                </a>
            </div>
        </div>
    </section>

    {{-- ============ JURUSAN LAINNYA ============ --}}
    @if($otherMajors->isNotEmpty())
    <section class="bg-skblue-50/60 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2 reveal">Jelajahi Lainnya</p>
            <h2 class="font-display font-extrabold text-2xl text-slate-800 mb-8 reveal">Jurusan Lain di {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}</h2>

            <div class="grid sm:grid-cols-2 gap-6">
                @foreach($otherMajors as $other)
                    <a href="{{ route('jurusan.show', $other['slug']) }}"
                       class="group bg-white rounded-2xl border border-skblue-100 p-6 flex items-center gap-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-200 reveal">
                        <div class="shrink-0 group-hover:scale-110 transition-transform duration-200">
                            @include('partials.major-badge', ['major' => $other, 'size' => 'md'])
                        </div>
                        <div>
                            <p class="font-display font-bold text-slate-800">{{ $other['name'] }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $other['desc'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection