@extends('layouts.public')

@section('title', ($schoolName ?? 'SMK Negeri 1 Sebulu') . ' — Beranda')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative isolate">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img
                src="{{ $theme?->hero_image ? asset('storage/'.$theme->hero_image) : asset('images/hero-bg.jpg') }}"
                alt="Foto {{ $schoolName ?? 'Sekolah' }}"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-br from-skblue-900/85 via-skblue-800/70 to-skblue-600/50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-20 pb-8 md:pt-28 xl:pb-20 grid lg:grid-cols-5 gap-10 items-center">
            <div class="lg:col-span-3 reveal-left">
                <p class="inline-flex items-center gap-2 text-xs md:text-sm font-semibold tracking-wide uppercase text-white bg-white/10 border border-white/25 rounded-full px-4 py-1.5 backdrop-blur-sm mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-skgold-400"></span>
                    Sistem Informasi Sekolah
                </p>
                <h1 class="font-display font-extrabold text-white text-4xl md:text-6xl leading-[1.1] tracking-tight drop-shadow-sm">
                    Mencetak Generasi<br>
                    <span class="text-skblue-200">Unggul &amp; Siap Kerja</span>
                </h1>
                <p class="text-skblue-50/90 text-base md:text-lg max-w-xl mt-6 leading-relaxed">
                    Selamat datang di portal resmi {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }} — pantau informasi sekolah,
                    ikuti pendaftaran siswa baru, dan temukan jurusan yang paling sesuai dengan minatmu.
                </p>
                <div class="flex flex-wrap gap-4 mt-8">
                    <a href="{{ route('ppdb.applicants.create') }}"
                       class="rounded-full bg-white text-skblue-700 hover:bg-skblue-50 font-bold px-7 py-3.5 shadow-xl transition">
                        Daftar PPDB Sekarang
                    </a>
                    @php
                        // Ganti nomor di bawah ini dengan nomor WhatsApp admin/humas sekolah yang sebenarnya
                        // Format: kode negara tanpa "+" atau "0" di depan, contoh: 62812xxxxxxx
                        $waNumber = '6289530319864';
                        $waMessage = urlencode("Halo, saya ingin bertanya seputar {$schoolName}.");
                    @endphp
                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}"
                       target="_blank" rel="noopener"
                       class="group rounded-full border-2 border-white/60 text-white hover:bg-white/10 font-bold px-7 py-3.5 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 00-8.6 15L2 22l5.2-1.4A10 10 0 1012 2zm5.8 14.2c-.2.7-1.4 1.3-2 1.4-.5.1-1.1.1-1.8-.1a15 15 0 01-4.1-2 12 12 0 01-2.6-3.2c-.4-.6-.8-1.3-.8-2.1 0-.8.4-1.6 1-2 .2-.2.5-.3.8-.3h.5c.2 0 .4 0 .5.4l.9 2c.1.2.1.4 0 .5l-.5.6c-.1.2-.2.3-.1.5.5 1 1.2 1.8 2.1 2.4.2.1.4.1.5 0l.6-.6c.2-.1.3-.2.5-.1l2 1c.1.1.3.1.3.3.1.2.1.9-.1 1.3z"/>
                        </svg>
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>

            {{-- Kartu statistik ringkas --}}
            <div class="lg:col-span-2 grid grid-cols-2 gap-4 reveal-right">
                @foreach([
                    ['label' => 'Siswa Aktif', 'value' => '278+'],
                    ['label' => 'Tenaga Pengajar', 'value' => '28'],
                    ['label' => 'Program Jurusan', 'value' => '3'],
                    ['label' => 'Tingkat Kelulusan', 'value' => '98%'],
                ] as $stat)
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-center">
                        <p class="font-display font-extrabold text-white text-2xl md:text-3xl">{{ $stat['value'] }}</p>
                        <p class="text-skblue-100 text-xs md:text-sm mt-1">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Bingkai mengambang (floating glass card) — dipertahankan, tapi sekarang pakai margin negatif
         (bukan absolute) supaya tinggi kartu selalu dihitung otomatis oleh browser dan TIDAK
         akan pernah nabrak/tumpang tindih dengan section di bawahnya, di layar berapapun (termasuk HP). --}}
    <div class="relative z-10 px-6 mt-6 xl:-mt-20">
        <div class="max-w-4xl mx-auto bg-white/90 md:bg-white/80 backdrop-blur-xl border border-white/60 rounded-3xl shadow-2xl shadow-skblue-900/20 px-5 py-6 md:px-10 md:py-8 grid sm:grid-cols-3 gap-3 sm:gap-4">

            <a href="{{ route('ppdb.applicants.create') }}"
               class="group flex flex-col items-center text-center gap-2 rounded-2xl px-4 py-4 sm:py-5 hover:bg-skblue-50 transition">
                <div class="w-12 h-12 rounded-full bg-skblue-600 group-hover:bg-skblue-700 text-white flex items-center justify-center shadow-md shadow-skblue-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <p class="font-display font-semibold text-skblue-900 text-sm">Pendaftaran PPDB</p>
                <p class="text-xs text-slate-500">Daftar siswa baru online</p>
            </a>

            <a href="{{ route('ppdb.persyaratan') }}"
            class="group flex flex-col items-center text-center gap-2 rounded-2xl px-4 py-4 sm:py-5 hover:bg-skblue-50 transition">

                <div class="w-12 h-12 rounded-full bg-skblue-500 group-hover:bg-skblue-600 text-white flex items-center justify-center shadow-md shadow-skblue-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 3v5h5"/>
                    </svg>
                </div>

                <p class="font-display font-semibold text-skblue-900 text-sm">
                    Persyaratan
                </p>

                <p class="text-xs text-slate-500">
                    Syarat pendaftaran siswa baru
                </p>

            </a>

            <a href="{{ route('ppdb.pengumuman') }}"
               class="group flex flex-col items-center text-center gap-2 rounded-2xl px-4 py-4 sm:py-5 hover:bg-skblue-50 transition">
                <div class="w-12 h-12 rounded-full bg-skblue-400 group-hover:bg-skblue-500 text-white flex items-center justify-center shadow-md shadow-skblue-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <p class="font-display font-semibold text-skblue-900 text-sm">Pengumuman</p>
                <p class="text-xs text-slate-500">Info terbaru sekolah</p>
            </a>

        </div>
    </div>

    <div class="h-10 md:h-16"></div>

    {{-- ============ PENGUMUMAN ============ --}}
    @if($announcements->isNotEmpty())
    <section id="pengumuman" class="max-w-7xl mx-auto px-6 py-6">
        <div class="bg-skblue-50 border border-skblue-100 rounded-2xl p-5 flex flex-col md:flex-row gap-4 md:items-center reveal">
            <span class="shrink-0 text-xs font-bold uppercase tracking-wide text-white bg-skblue-600 rounded-full px-3 py-1">Pengumuman</span>
            <div class="flex-1 flex flex-wrap gap-x-8 gap-y-2 text-sm text-skblue-900">
                @foreach($announcements as $a)
                    <span>📌 {{ $a->title }}</span>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ SAMBUTAN KEPALA SEKOLAH ============ --}}
    <section id="sambutan" class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

            {{-- Kiri: teks sambutan --}}
            <div class="reveal-left">
                <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-3">Sambutan</p>
                <h2 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800 leading-tight mb-6">
                    Mewujudkan <span class="text-skblue-600">Generasi Unggul</span> &amp; Berkarakter
                </h2>

                <div class="border-l-4 border-skblue-500 pl-5 space-y-4 text-sm md:text-base text-slate-600 leading-relaxed">
                    <p class="font-semibold text-slate-700">Assalamu'alaikum Warahmatullahi Wabarakatuh.</p>
                    <p>
                        Puji syukur kami panjatkan atas terbitnya website resmi
                        <span class="font-semibold text-skblue-700">{{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}</span>.
                        Website ini hadir sebagai wujud komitmen kami dalam menjawab kebutuhan informasi digital
                        yang cepat, transparan, dan akurat di era modern ini.
                    </p>
                    <p>
                        Kami berharap sarana ini tidak hanya menjadi media informasi, tetapi juga jembatan yang
                        mempererat tali silaturahmi antara sekolah, orang tua, alumni, dan masyarakat luas — sekaligus
                        mendukung terciptanya lulusan yang kompeten, mandiri, dan siap bersaing di dunia kerja maupun industri.
                    </p>
                    <p class="font-semibold text-slate-700">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
                </div>

                <div class="mt-8">
                    <p class="font-display font-bold text-slate-800 text-lg">{{ $principal['name'] ?? 'Herjan, S.Pd.' }}</p>
                    <p class="text-skblue-600 text-sm font-medium flex items-center gap-2 mt-1">
                        <span class="w-6 h-px bg-skblue-400"></span>
                        Kepala {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}
                    </p>
                </div>

                <a href="{{ route('profil') }}"
                   class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-skblue-600 hover:text-skblue-800 transition">
                    Selengkapnya tentang kami
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Kanan: foto kepala sekolah --}}
            <div class="relative reveal-right">
                <div class="absolute -inset-6 -z-10">
                    <div class="w-full h-full rounded-full bg-gradient-to-br from-skblue-100 to-skblue-200/60 blur-2xl"></div>
                </div>

                <div class="relative rounded-3xl overflow-hidden shadow-soft aspect-[4/5] max-w-md mx-auto bg-skblue-100">
                    <img src="{{ !empty($principal['photo']) ? asset('storage/'.$principal['photo']) : asset('images/kepala-sekolah.jpg') }}"
                         alt="Kepala {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}"
                         class="w-full h-full object-cover object-top">
                </div>

                {{-- Kartu info mengambang --}}
                <div class="absolute bottom-6 -left-4 md:left-6 bg-white rounded-2xl shadow-soft px-5 py-4 flex items-center gap-3 max-w-[240px] animate-float">
                    <div class="shrink-0 w-11 h-11 rounded-xl bg-skblue-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 14.09V19a1 1 0 01-1 1H4a1 1 0 01-1-1v-4.91a12.083 12.083 0 012.84-3.512L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-skblue-900 text-sm leading-tight">Pendidikan Berbasis</p>
                        <p class="text-xs text-slate-500">Kompetensi &amp; Karakter</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ============ KENAPA MEMILIH KAMI ============ --}}
    <section id="keunggulan" class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center max-w-2xl mx-auto mb-14 reveal">
            <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2">Kenapa Memilih Kami</p>
            <h2 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800">Fasilitas &amp; Keunggulan Sekolah</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['slug' => 'kelas', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m9-13h.01M9 8h.01M9 12h.01M12 12h.01M9 16h.01M12 16h.01M15 12h.01M15 16h.01', 'title' => 'Ruang Kelas Modern', 'desc' => 'Dilengkapi proyektor & AC di setiap ruang belajar.'],
                ['slug' => 'lab', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Laboratorium Praktik', 'desc' => 'Lab komputer, jaringan, dan bengkel sesuai standar industri.'],
                ['slug' => 'guru', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4', 'title' => 'Guru Berpengalaman', 'desc' => 'Tenaga pengajar profesional dan bersertifikasi kompetensi.'],
                ['slug' => 'industri', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Kerja Sama Industri', 'desc' => 'Program magang & penyaluran kerja bersama mitra industri.'],
            ] as $feature)
                @php
                    $featurePhoto = "images/fasilitas/{$feature['slug']}.jpg";
                    $hasPhoto = file_exists(public_path($featurePhoto));
                @endphp

                @if($hasPhoto)
                    {{-- Versi foto: dipakai otomatis kalau foto sudah diupload ke public/images/fasilitas/{slug}.jpg --}}
                    <div class="group relative rounded-2xl overflow-hidden h-64 reveal reveal-delay-{{ $loop->iteration }}">
                        <img src="{{ asset($featurePhoto) }}" alt="{{ $feature['title'] }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-skblue-900/90 via-skblue-900/30 to-transparent"></div>

                        <div class="absolute top-4 left-4 w-11 h-11 rounded-xl bg-white/15 backdrop-blur-sm border border-white/25 flex items-center justify-center group-hover:bg-skblue-600 group-hover:border-skblue-600 transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/>
                            </svg>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="font-display font-bold text-white mb-1">{{ $feature['title'] }}</h3>
                            <p class="text-sm text-white/80 leading-relaxed">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                @else
                    {{-- Versi default (ikon polos): dipakai selama foto belum diupload --}}
                    <div class="group rounded-2xl border border-skblue-100 hover:border-skblue-300 hover:shadow-soft p-6 transition reveal reveal-delay-{{ $loop->iteration }}">
                        <div class="w-12 h-12 rounded-xl bg-skblue-100 group-hover:bg-skblue-600 flex items-center justify-center transition">
                            <svg class="w-6 h-6 text-skblue-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-slate-800 mt-4 mb-1.5">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- ============ JURUSAN UNGGULAN ============ --}}
    <section id="jurusan" class="bg-skblue-50/60 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14 reveal">
                <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2">Program Keahlian</p>
                <h2 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800">Jurusan Unggulan Kami</h2>
                <p class="text-sm text-slate-500 mt-3">Klik salah satu jurusan untuk melihat detail, fasilitas, dan galerinya.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($majors ?? [
                    ['slug' => 'tkj', 'code' => 'TKJ', 'name' => 'Teknik Komputer & Jaringan', 'desc' => 'Instalasi jaringan, administrasi server, dan keamanan sistem informasi.', 'icon' => 'network', 'color_from' => 'from-skblue-500', 'color_to' => 'to-skblue-700'],
                    ['slug' => 'mp', 'code' => 'MP', 'name' => 'Manajemen Perkantoran', 'desc' => 'Pengelolaan administrasi perkantoran, komunikasi bisnis, dan layanan pelanggan.', 'icon' => 'briefcase', 'color_from' => 'from-skblue-400', 'color_to' => 'to-skblue-600'],
                    ['slug' => 'atp', 'code' => 'ATP', 'name' => 'Agribisnis Tanaman Perkebunan', 'desc' => 'Pengelolaan dan pengembangan tanaman perkebunan, termasuk praktik pertanian berkelanjutan.', 'icon' => 'leaf', 'color_from' => 'from-emerald-500', 'color_to' => 'to-skblue-600'],
                ] as $major)
                    <a href="{{ route('jurusan.show', $major['slug']) }}"
                       class="group bg-white rounded-2xl overflow-hidden border border-skblue-100 hover:border-skblue-300 hover:shadow-2xl hover:shadow-skblue-900/10 hover:-translate-y-3 transition-all duration-300 ease-out reveal reveal-delay-{{ $loop->iteration % 4 }}">
                        <div class="h-2 bg-gradient-to-r {{ $major['color_from'] }} {{ $major['color_to'] }}"></div>
                        <div class="p-6">
                            {{-- Logo/ikon jurusan — "timbul" naik & membesar dikit pas kartu di-hover --}}
                            <div class="mb-4 transition-all duration-300 ease-out group-hover:-translate-y-2 group-hover:scale-110">
                                @include('partials.major-badge', ['major' => $major, 'size' => 'md'])
                            </div>

                            <p class="text-xs font-bold text-skblue-500 tracking-widest mb-2">SPEK. {{ $loop->iteration }} / {{ $major['code'] }}</p>
                            <h3 class="font-display font-bold text-lg text-slate-800 mb-2 group-hover:text-skblue-700 transition-colors duration-200">{{ $major['name'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $major['desc'] }}</p>

                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-skblue-600 mt-4 group-hover:gap-2.5 transition-all duration-200">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ BERITA TERBARU ============ --}}
    <section id="berita" class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex items-end justify-between mb-10">
            <div class="reveal">
                <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2">Kabar Sekolah</p>
                <h2 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800">Berita &amp; Kegiatan Terbaru</h2>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($latestNews as $news)
                <article class="bg-white rounded-2xl overflow-hidden border border-skblue-100 shadow-sm hover:shadow-soft hover:-translate-y-1 transition reveal-zoom">
                    <div class="h-44 bg-skblue-100">
                        @if($news->cover_image)
                            <img src="{{ asset('storage/'.$news->cover_image) }}" class="w-full h-full object-cover" alt="{{ $news->title }}">
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-skblue-500 mb-1">{{ optional($news->published_at)->translatedFormat('d F Y') }}</p>
                        <h3 class="font-display font-semibold text-slate-800 leading-snug mb-2">{{ $news->title }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2">{{ $news->excerpt }}</p>
                    </div>
                </article>
            @empty
                <p class="text-slate-400 text-sm col-span-3">Belum ada berita yang dipublikasikan.</p>
            @endforelse
        </div>
    </section>

    {{-- ============ GALERI ============ --}}
    <section id="galeri" class="bg-skblue-50/60 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14 reveal">
                <p class="text-skblue-600 text-xs font-bold uppercase tracking-widest mb-2">Dokumentasi</p>
                <h2 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800">Galeri Kegiatan Sekolah</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($galleries ?? [] as $item)
                    <button type="button"
                            onclick="openGaleriLightbox(this)"
                            data-src="{{ url('storage/'.$item->image_path) }}"
                            data-title="{{ $item->title }}"
                            data-caption="{{ $item->caption ?? '' }}"
                            class="group rounded-2xl overflow-hidden h-48 bg-skblue-100 reveal-zoom relative cursor-pointer text-left">
                        <img src="{{ url('storage/'.$item->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $item->title }}">
                        {{-- Overlay judul, muncul pas di-hover, sekalian nandain kalau foto ini bisa diklik --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/0 to-slate-900/0 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-3">
                            <p class="text-white text-xs font-semibold leading-snug line-clamp-2">{{ $item->title }}</p>
                        </div>
                    </button>
                @empty
                    @for($i = 0; $i < 4; $i++)
                        <div class="rounded-2xl h-48 bg-skblue-100/70 flex items-center justify-center text-skblue-300 text-xs">
                            Belum ada foto
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ LIGHTBOX GALERI (modal buat lihat foto + deskripsi) ============ --}}
    <div id="galeriLightbox"
         class="hidden fixed inset-0 z-[100] bg-slate-900/90 backdrop-blur-sm items-center justify-center p-4 md:p-8"
         onclick="if(event.target === this) closeGaleriLightbox()">
        <button type="button" onclick="closeGaleriLightbox()"
                class="absolute top-4 right-4 md:top-6 md:right-6 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="max-w-3xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col">
            <div class="bg-black shrink-0 flex items-center justify-center max-h-[65vh] overflow-hidden">
                <img id="galeriLightboxImg" src="" alt="" class="max-h-[65vh] w-full object-contain">
            </div>
            <div class="p-5 md:p-6 overflow-y-auto">
                <h3 id="galeriLightboxTitle" class="font-display font-bold text-lg text-slate-800 mb-2"></h3>
                <p id="galeriLightboxCaption" class="text-sm text-slate-500 leading-relaxed"></p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Lightbox galeri: buka modal pas foto diklik, nampilin gambar penuh + judul + deskripsi
    function openGaleriLightbox(el) {
        document.getElementById('galeriLightboxImg').src = el.dataset.src;
        document.getElementById('galeriLightboxImg').alt = el.dataset.title;
        document.getElementById('galeriLightboxTitle').textContent = el.dataset.title;

        const captionEl = document.getElementById('galeriLightboxCaption');
        if (el.dataset.caption && el.dataset.caption.trim() !== '') {
            captionEl.textContent = el.dataset.caption;
        } else {
            captionEl.textContent = 'Belum ada deskripsi untuk foto ini.';
        }

        const modal = document.getElementById('galeriLightbox');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // kunci scroll belakang modal
    }

    function closeGaleriLightbox() {
        const modal = document.getElementById('galeriLightbox');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Tutup modal kalau pencet tombol Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeGaleriLightbox();
    });
</script>
@endpush