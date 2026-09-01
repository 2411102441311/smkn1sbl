<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $schoolName ?? 'SMK Negeri 1 Sebulu')</title>
    <meta name="description" content="Sistem Informasi {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }} — profil sekolah, jurusan, berita, dan pendaftaran siswa baru.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        // Palet biru muda khas SMK
                        skblue: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            200: '#BFDBFE',
                            300: '#93C5FD',
                            400: '#60A5FA',
                            500: '#3B82F6',
                            600: '#2563EB',
                            700: '#1D4ED8',
                            800: '#1E40AF',
                            900: '#1E3A8A',
                        },
                        skgold: {
                            400: '#FBBF24',
                            500: '#F59E0B',
                        },
                    },
                    boxShadow: {
                        soft: '0 10px 40px -10px rgba(29, 78, 216, 0.25)',
                    }
                }
            }
        }
    </script>
    <style>
        .bg-noise { background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,.12) 1px, transparent 0); background-size: 22px 22px; }

        /* ===== Animasi scroll reveal: hilang lalu muncul saat di-scroll ===== */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Variasi arah, tinggal tambah class ini kalau mau beda gaya */
        .reveal-left  { opacity: 0; transform: translateX(-32px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal-left.is-visible  { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(32px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal-right.is-visible { opacity: 1; transform: translateX(0); }
        .reveal-zoom   { opacity: 0; transform: scale(0.92); transition: opacity 0.6s ease, transform 0.6s ease; }
        .reveal-zoom.is-visible   { opacity: 1; transform: scale(1); }

        /* Delay bertahap untuk grid/kartu berurutan (opsional, tambahkan class reveal-delay-1 s/d 4) */
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* ===== Marquee / ticker berjalan otomatis ===== */
        .marquee-track {
            width: max-content;
            animation: marquee-scroll 28s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused; /* berhenti sebentar saat kursor di atasnya, biar bisa dibaca */
        }
        @keyframes marquee-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); } /* -50% karena isinya diulang 2x (lihat blade) */
        }

        /* ===== Animasi melayang naik-turun pelan (untuk kartu mengambang) ===== */
        .animate-float {
            animation: float-bob 3.5s ease-in-out infinite;
        }
        @keyframes float-bob {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
    </style>
    @stack('styles')
</head>
<body class="font-body bg-white text-slate-700 antialiased">

    {{-- ============ TOPBAR (kontak, diam) ============ --}}
    <div class="bg-skblue-900 text-skblue-100 text-[10px] md:text-xs">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-1.5 md:py-2 flex items-center justify-center md:justify-between gap-3 md:gap-6 flex-wrap">
            <div class="flex items-center gap-3 md:gap-6 flex-wrap justify-center">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3 h-3 md:w-3.5 md:h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ \App\Models\CMS\Setting::get('school_email', 'info@smkn1sebulu.sch.id') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3 h-3 md:w-3.5 md:h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ \App\Models\CMS\Setting::get('school_phone', '(0895) 3031-9864') }}
                </span>
            </div>
            <p class="hidden md:block">Akreditasi A &middot; Sekolah Berbasis Kompetensi</p>
        </div>
    </div>

    {{-- ============ MARQUEE / TICKER BERJALAN ============ --}}
    <div class="bg-skblue-950 bg-skblue-800 text-white text-xs overflow-hidden py-2 border-b border-skblue-700">
        <div class="marquee-track flex items-center gap-10 whitespace-nowrap">
            @php
                $tickerItems = [
                    ['icon' => '⭐', 'text' => 'Terakreditasi "A" Unggul oleh BAN-SM'],
                    ['icon' => '✅', 'text' => '3 Program Keahlian Siap Kerja & Wirausaha'],
                    ['icon' => '🔥', 'text' => 'Info Terbaru: Pendaftaran PPDB Sedang Dibuka'],
                    ['icon' => '🤝', 'text' => 'Bermitra dengan Dunia Usaha & Industri (DUDI)'],
                    ['icon' => '🎓', 'text' => 'Ratusan Alumni Tersalurkan Kerja Setiap Tahun'],
                ];
            @endphp
            {{-- Diulang 2x supaya loop-nya nyambung mulus tanpa jeda --}}
            @for($rep = 0; $rep < 2; $rep++)
                @foreach($tickerItems as $item)
                    <span class="flex items-center gap-2 font-medium tracking-wide">
                        <span>{{ $item['icon'] }}</span>
                        <span>{{ $item['text'] }}</span>
                        <span class="text-skblue-400 ml-8">&bull;</span>
                    </span>
                @endforeach
            @endfor
        </div>
    </div>

    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-skblue-100">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="relative w-11 h-11 shrink-0">
                    <img src="{{ asset('images/logo-smkn1sbl2.png') }}" alt="Logo {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}" class="w-full h-full object-contain drop-shadow">
                </div>
                <div class="leading-tight">
                    <p class="font-display font-extrabold text-skblue-900 text-sm md:text-base tracking-tight">{{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}</p>
                    <p class="text-[10px] md:text-[11px] text-skblue-500 font-medium tracking-wide uppercase">Unggul &middot; Kompeten &middot; Berkarakter</p>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-2 text-sm font-semibold text-slate-600">
                <div class="relative group/profil">
                    <a href="{{ route('profil') }}" class="relative px-3 py-2 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-1">
                        Profil
                        <svg class="w-3.5 h-3.5 group-hover/profil:rotate-180 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    {{-- Dropdown submenu Profil --}}
                    <div class="absolute left-0 top-full pt-2 w-56 opacity-0 invisible translate-y-1 group-hover/profil:opacity-100 group-hover/profil:visible group-hover/profil:translate-y-0 transition-all duration-200 z-50">
                        <div class="bg-white rounded-2xl border border-skblue-100 shadow-soft py-2 overflow-hidden">
                            @foreach([
                                ['label' => 'Sejarah', 'anchor' => 'sejarah'],
                                ['label' => 'Visi & Misi', 'anchor' => 'visi-misi'],
                                ['label' => 'Struktur Organisasi', 'anchor' => 'struktur'],
                                ['label' => 'Daftar Guru', 'anchor' => 'guru'],
                                ['label' => 'Prestasi', 'anchor' => 'prestasi'],
                                ['label' => 'Ekstrakurikuler', 'anchor' => 'ekstrakurikuler'],
                            ] as $sub)
                                <a href="{{ route('profil') }}#{{ $sub['anchor'] }}"
                                   class="block px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-skblue-50 hover:text-skblue-700 hover:pl-5 transition-all duration-200">
                                    {{ $sub['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="relative group/jurusan">
                    <a href="{{ route('home') }}#jurusan" class="relative px-3 py-2 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-1">
                        Jurusan
                        <svg class="w-3.5 h-3.5 group-hover/jurusan:rotate-180 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    {{-- Dropdown submenu Jurusan --}}
                    <div class="absolute left-0 top-full pt-2 w-64 opacity-0 invisible translate-y-1 group-hover/jurusan:opacity-100 group-hover/jurusan:visible group-hover/jurusan:translate-y-0 transition-all duration-200 z-50">
                        <div class="bg-white rounded-2xl border border-skblue-100 shadow-soft py-2 overflow-hidden">
                            @foreach(\App\Http\Controllers\MajorController::data() as $navMajor)
                                <a href="{{ route('jurusan.show', $navMajor['slug']) }}"
                                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-skblue-50 transition-all duration-200 group/item">
                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $navMajor['color_from'] }} {{ $navMajor['color_to'] }} flex items-center justify-center shrink-0">
                                        @include('partials.major-icon', ['icon' => $navMajor['icon'], 'class' => 'w-4 h-4 text-white'])
                                    </span>
                                    <span class="text-sm font-medium text-slate-600 group-hover/item:text-skblue-700 group-hover/item:translate-x-0.5 transition-all duration-200">
                                        {{ $navMajor['name'] }}
                                    </span>
                                </a>
                            @endforeach
                            <div class="border-t border-skblue-50 mt-1 pt-1">
                                <a href="{{ route('home') }}#jurusan"
                                   class="block px-4 py-2.5 text-sm font-semibold text-skblue-600 hover:bg-skblue-50 transition">
                                    Lihat Semua Jurusan →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home') }}#berita" class="relative px-3 py-2 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 hover:-translate-y-0.5 transition-all duration-200">Berita</a>
                <a href="{{ route('home') }}#galeri" class="relative px-3 py-2 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 hover:-translate-y-0.5 transition-all duration-200">Galeri</a>
               
            </nav>

            <div class="flex items-center justify-end gap-2 md:gap-3">
                <a href="{{ route('ppdb.applicants.create') }}"
                   class="rounded-full bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white text-xs md:text-sm font-bold px-4 md:px-5 py-2.5 shadow-soft transition-all duration-200 leading-none whitespace-nowrap flex items-center">
                    Daftar PPDB
                </a>

                {{-- Tombol garis tiga — cuma muncul di mobile/tablet (di bawah breakpoint lg) --}}
                <button type="button" id="mobile-menu-btn" aria-label="Buka menu navigasi" aria-expanded="false"
                        class="lg:hidden shrink-0 w-10 h-10 rounded-lg border border-skblue-200 flex items-center justify-center text-skblue-700 hover:bg-skblue-50 hover:border-skblue-300 transition-colors duration-200 relative">
                    <svg id="icon-menu-open" class="w-5 h-5 absolute transition-all duration-300 ease-in-out opacity-100 rotate-0 scale-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-menu-close" class="w-5 h-5 absolute transition-all duration-300 ease-in-out opacity-0 rotate-90 scale-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Panel menu mobile — tersembunyi secara default, muncul saat tombol garis tiga ditekan --}}
        <div id="mobile-menu" class="max-h-0 opacity-0 overflow-hidden lg:hidden border-t border-skblue-100 bg-white transition-all duration-300 ease-in-out">
            <nav class="max-w-7xl mx-auto px-6 py-3 flex flex-col text-sm font-semibold text-slate-600">
                <a href="{{ route('profil') }}" class="px-3 py-3 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 transition font-semibold">Profil</a>
                <div class="flex flex-col mb-1 border-b border-skblue-50 pb-2">
                    @foreach([
                        ['label' => 'Sejarah', 'anchor' => 'sejarah'],
                        ['label' => 'Visi & Misi', 'anchor' => 'visi-misi'],
                        ['label' => 'Struktur Organisasi', 'anchor' => 'struktur'],
                        ['label' => 'Daftar Guru', 'anchor' => 'guru'],
                        ['label' => 'Prestasi', 'anchor' => 'prestasi'],
                        ['label' => 'Ekstrakurikuler', 'anchor' => 'ekstrakurikuler'],
                    ] as $sub)
                        <a href="{{ route('profil') }}#{{ $sub['anchor'] }}"
                           class="pl-7 pr-3 py-2 text-xs text-slate-500 hover:text-skblue-700 hover:bg-skblue-50 rounded-lg transition flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-skblue-300"></span>
                            {{ $sub['label'] }}
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('home') }}#jurusan" class="px-3 py-3 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 transition font-semibold">Jurusan</a>
                <div class="flex flex-col mb-1 border-b border-skblue-50 pb-2">
                    @foreach(\App\Http\Controllers\MajorController::data() as $navMajor)
                        <a href="{{ route('jurusan.show', $navMajor['slug']) }}"
                           class="pl-7 pr-3 py-2 text-xs text-slate-500 hover:text-skblue-700 hover:bg-skblue-50 rounded-lg transition flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-skblue-300"></span>
                            {{ $navMajor['name'] }}
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('home') }}berita" class="px-3 py-3 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 transition border-b border-skblue-50">Berita</a>
                <a href="{{ route('home') }}galeri" class="px-3 py-3 rounded-lg hover:text-skblue-700 hover:bg-skblue-50 transition border-b border-skblue-50">Galeri</a>
            </nav>
        </div>
    </header>

    <script>
        // Toggle menu mobile (tombol garis tiga) — dengan animasi transisi ikon & panel
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('icon-menu-open');
            const iconClose = document.getElementById('icon-menu-close');

            function showOpenIcon() {
                iconOpen.classList.remove('opacity-0', '-rotate-90', 'scale-50');
                iconOpen.classList.add('opacity-100', 'rotate-0', 'scale-100');
                iconClose.classList.remove('opacity-100', 'rotate-0', 'scale-100');
                iconClose.classList.add('opacity-0', 'rotate-90', 'scale-50');
            }

            function showCloseIcon() {
                iconClose.classList.remove('opacity-0', 'rotate-90', 'scale-50');
                iconClose.classList.add('opacity-100', 'rotate-0', 'scale-100');
                iconOpen.classList.remove('opacity-100', 'rotate-0', 'scale-100');
                iconOpen.classList.add('opacity-0', '-rotate-90', 'scale-50');
            }

            function openMenu() {
                menu.style.maxHeight = menu.scrollHeight + 'px';
                menu.classList.remove('opacity-0');
                menu.classList.add('opacity-100');
                showCloseIcon();
                btn.setAttribute('aria-expanded', 'true');
            }

            function closeMenu() {
                menu.style.maxHeight = '0px';
                menu.classList.remove('opacity-100');
                menu.classList.add('opacity-0');
                showOpenIcon();
                btn.setAttribute('aria-expanded', 'false');
            }

            if (btn && menu) {
                btn.addEventListener('click', function () {
                    const isOpen = menu.classList.contains('opacity-100');
                    isOpen ? closeMenu() : openMenu();
                });

                // Otomatis tutup menu kalau salah satu link diklik
                menu.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', closeMenu);
                });

                // Jaga-jaga: kalau ukuran layar berubah (misal rotate HP) selagi menu terbuka,
                // sesuaikan ulang tinggi maksimalnya biar animasi tetap pas.
                window.addEventListener('resize', function () {
                    if (menu.classList.contains('opacity-100')) {
                        menu.style.maxHeight = menu.scrollHeight + 'px';
                    }
                });
            }
        });
    </script>

    <main>
        @yield('content')
    </main>

    {{-- ============ CTA BANNER ============ --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-skblue-700 to-skblue-500">
        <div class="absolute inset-0 bg-noise opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-14 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div>
                <h3 class="font-display font-extrabold text-white text-2xl md:text-3xl">Siap Bergabung Bersama Kami?</h3>
                <p class="text-skblue-50/90 mt-2 max-w-xl">Pendaftaran Peserta Didik Baru {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }} sudah dibuka. Amankan kuota jurusan pilihanmu sekarang.</p>
            </div>
            <a href="{{ route('ppdb.applicants.create') }}"
               class="shrink-0 rounded-full bg-white text-skblue-700 hover:bg-skblue-50 font-bold px-7 py-3.5 shadow-xl transition">
                Daftar Sekarang &rarr;
            </a>
        </div>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-skblue-900 text-skblue-100">
        <div class="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-3 gap-12">

            {{-- Kolom 1: Brand + deskripsi + sosial media --}}
            <div class="reveal">
                <p class="font-display font-extrabold text-white text-xl mb-3">
                    {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}
                </p>
                <p class="text-sm text-skblue-300 leading-relaxed mb-6">
                    Mencetak lulusan yang kompeten, mandiri, berkarakter, dan siap bersaing di dunia kerja maupun industri.
                </p>
                <div class="flex gap-3">
                    @foreach([
                        ['name' => 'instagram', 'path' => 'M12 8.5a3.5 3.5 0 100 7 3.5 3.5 0 000-7zM12 2c-2.7 0-3.1 0-4.1.1-1.1 0-1.8.2-2.5.5-.7.3-1.3.6-1.9 1.2-.6.6-.9 1.2-1.2 1.9-.3.7-.4 1.4-.5 2.5C1.7 9.2 1.7 9.6 1.7 12.3s0 3.1.1 4.1c.1 1.1.2 1.8.5 2.5.3.7.6 1.3 1.2 1.9.6.6 1.2.9 1.9 1.2.7.3 1.4.4 2.5.5 1 .1 1.4.1 4.1.1s3.1 0 4.1-.1c1.1-.1 1.8-.2 2.5-.5.7-.3 1.3-.6 1.9-1.2.6-.6.9-1.2 1.2-1.9.3-.7.4-1.4.5-2.5.1-1 .1-1.4.1-4.1s0-3.1-.1-4.1c-.1-1.1-.2-1.8-.5-2.5a5 5 0 00-1.2-1.9 5 5 0 00-1.9-1.2c-.7-.3-1.4-.4-2.5-.5C15.1 2 14.7 2 12 2z'],
                        ['name' => 'facebook', 'path' => 'M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7A10 10 0 0022 12z'],
                        ['name' => 'youtube', 'path' => 'M21.8 8.1a2.5 2.5 0 00-1.8-1.8C18.3 6 12 6 12 6s-6.3 0-8 .3A2.5 2.5 0 002.2 8.1 26 26 0 002 12a26 26 0 00.2 3.9 2.5 2.5 0 001.8 1.8c1.7.3 8 .3 8 .3s6.3 0 8-.3a2.5 2.5 0 001.8-1.8A26 26 0 0022 12a26 26 0 00-.2-3.9zM10 15V9l5.2 3-5.2 3z'],
                    ] as $social)
                        <a href="#"
                           class="w-10 h-10 rounded-full bg-white/10 border border-white/10 hover:bg-skblue-500 hover:border-skblue-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-skblue-500/30 flex items-center justify-center transition-all duration-200">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $social['path'] }}"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Kolom 2: Akses cepat --}}
            <div class="reveal reveal-delay-1">
                <p class="text-xs font-bold uppercase tracking-widest text-skblue-400 mb-5">Akses Cepat</p>
                <ul class="space-y-3 text-sm">
                    @foreach([
                        ['label' => 'Beranda', 'url' => route('home')],
                        ['label' => 'Profil Sekolah', 'url' => route('profil')],
                        ['label' => 'Jurusan', 'url' => route('home').'jurusan'],
                        ['label' => 'Berita', 'url' => route('home').'berita'],
                        ['label' => 'Galeri', 'url' => route('home').'galeri'],
                        ['label' => 'Pendaftaran PPDB', 'url' => route('ppdb.applicants.create')],
                    ] as $link)
                        <li>
                            <a href="{{ $link['url'] }}"
                               class="group flex items-center gap-2.5 text-skblue-300 hover:text-white transition-colors duration-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-skblue-500 group-hover:bg-white group-hover:scale-125 transition-all duration-200"></span>
                                <span class="group-hover:translate-x-1 transition-transform duration-200">{{ $link['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Kolom 3: Pusat informasi & lokasi --}}
            <div class="reveal reveal-delay-2">
                <p class="text-xs font-bold uppercase tracking-widest text-skblue-400 mb-5">Pusat Informasi &amp; Lokasi</p>

                <div class="space-y-4">
                    {{-- Telepon --}}
                    <a href="tel:{{ \App\Models\CMS\Setting::get('school_phone', '') }}"
                       class="group flex items-start gap-3 rounded-xl p-3 -m-3 border border-transparent hover:border-skblue-700 hover:bg-white/5 transition-all duration-200">
                        <span class="shrink-0 w-9 h-9 rounded-lg bg-skblue-500/20 group-hover:bg-skblue-500 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-4 h-4 text-skblue-300 group-hover:text-white transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </span>
                        <span>
                            <span class="block text-sm font-semibold text-white">{{ \App\Models\CMS\Setting::get('school_phone', '(0895) 3031-9864') }}</span>
                            <span class="block text-xs text-skblue-400 mt-0.5">
                                Senin&ndash;Kamis, 07.00&ndash;15.00 WITA<br>
                                Jum'at, 07.00&ndash;11.00 WITA
                            </span>
                        </span>
                    </a>

                    {{-- Alamat --}}
                    @php
                        $address = \App\Models\CMS\Setting::get('school_address', $schoolName ?? 'SMK Negeri 1 Sebulu');
                        $mapLat = '-0.2723846';
                        $mapLng = '117.0067578';
                    @endphp
                    <a href="https://www.google.com/maps/place/SMKN+1+Sebulu/@{{ $mapLat }},{{ $mapLng }},18z" target="_blank" rel="noopener"
                       class="group flex items-start gap-3 rounded-xl p-3 -m-3 border border-transparent hover:border-skblue-700 hover:bg-white/5 transition-all duration-200">
                        <span class="shrink-0 w-9 h-9 rounded-lg bg-skblue-500/20 group-hover:bg-skblue-500 flex items-center justify-center transition-colors duration-200">
                            <svg class="w-4 h-4 text-skblue-300 group-hover:text-white transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </span>
                        <span>
                            <span class="block text-sm font-semibold text-white">Alamat Sekolah</span>
                            <span class="block text-xs text-skblue-400 mt-0.5 leading-relaxed">{{ $address }}</span>
                        </span>
                    </a>
                </div>

                {{-- Peta mini --}}
                @php
                    // Koordinat presisi SMKN 1 Sebulu (diambil dari link Google Maps)
                    $mapLat = '-0.2723846';
                    $mapLng = '117.0067578';
                    $mapZoom = 18;
                @endphp
                <div class="relative rounded-xl overflow-hidden border border-skblue-800 mt-5 hover:border-skblue-500 transition-colors duration-200">
                    <iframe
                        src="https://www.google.com/maps?q={{ $mapLat }},{{ $mapLng }}&z={{ $mapZoom }}&output=embed"
                        class="w-full h-36"
                        style="border:0; filter: grayscale(0.1) contrast(1.05);"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <a href="https://www.google.com/maps/place/SMKN+1+Sebulu/@{{ $mapLat }},{{ $mapLng }},{{ $mapZoom }}z"
                       target="_blank" rel="noopener"
                       class="absolute bottom-2 right-2 bg-white text-skblue-700 text-[11px] font-semibold px-2.5 py-1.5 rounded-md shadow hover:bg-skblue-50 hover:shadow-md transition-all duration-200">
                        Buka Maps
                    </a>
                </div>
            </div>

        </div>
        <div class="border-t border-skblue-800 text-center text-xs text-skblue-400 py-5">
            <div class="flex items-center justify-center gap-2">
                <span>&copy; {{ date('Y') }} {{ $schoolName ?? 'SMK Negeri 1 Sebulu' }}. Seluruh hak cipta dilindungi.</span>
                {{-- Ikon kecil ke halaman login staff — sengaja dibuat halus/gak mencolok, tanpa teks "Login Admin" --}}
                <a href="{{ route('login') }}" aria-label="Login staff"
                   class="text-skblue-600 hover:text-skblue-300 transition-colors duration-200 opacity-50 hover:opacity-100">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>
            </div>
            {{-- Kredit tim pengembang --}}
            <p class="text-[11px] text-skblue-500 mt-1.5">
                Dirancang oleh <span class="font-medium text-skblue-300">Mufidah Kholilah Putri</span>
                &middot; Dikembangkan oleh <span class="font-medium text-skblue-300">Zaskia Nabilah</span>
            </p>
        </div>
    </footer>

    <script>
        // Animasi scroll reveal: elemen ber-class .reveal / .reveal-left / .reveal-right / .reveal-zoom
        // akan otomatis muncul (fade + geser) begitu masuk area layar saat di-scroll.
        document.addEventListener('DOMContentLoaded', function () {
            const targets = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-zoom');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // cukup sekali animasi, tidak berulang tiap scroll
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -60px 0px',
            });

            targets.forEach((el) => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>