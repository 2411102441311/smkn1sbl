<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — {{ $schoolName ?? \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { skblue: {
             50:'#EFF6FF',100:'#DBEAFE',200:'#BFDBFE',300:'#93C5FD',400:'#60A5FA',
            500:'#3B82F6',600:'#2563EB',700:'#1D4ED8',800:'#1E40AF',900:'#1E3A8A',950:'#152B54'
        }}}}}
    </script>
    <style>
        aside nav::-webkit-scrollbar { width: 5px; }
        aside nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 999px; }
        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        main > * { animation: fadeSlideUp .4s ease-out both; }
    </style>
</head>
<body class="bg-gradient-to-br from-skblue-50 via-white to-skblue-50 text-slate-700">
@php
    $user = auth()->user();
    $isSuperAdmin = $user?->hasRole('super-admin') ?? false;

    $navClass = function (bool $active) {
        return $active
            ? 'bg-gradient-to-r from-skblue-500/90 to-skblue-400/80 text-white shadow-[0_0_18px_rgba(96,165,250,0.55)] ring-1 ring-skblue-300/50'
            : 'text-skblue-100/80 hover:text-white hover:bg-white/5 hover:shadow-[0_0_16px_rgba(96,165,250,0.35)] hover:ring-1 hover:ring-skblue-400/30';
    };
@endphp

<div class="flex min-h-screen">

    <div id="sidebarOverlay" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 md:hidden"></div>

    <aside id="adminSidebar"
           class="w-72 shrink-0 bg-gradient-to-b from-skblue-950 via-skblue-900 to-skblue-900 text-skblue-100 flex flex-col
                  fixed inset-y-0 left-0 z-50 -translate-x-full transition-transform duration-300 ease-out
                  md:static md:translate-x-0">

        <div class="px-6 py-5 border-b border-white/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-skblue-400 to-skblue-600 shadow-[0_0_20px_rgba(96,165,250,0.6)] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 14.09V19a1 1 0 01-1 1H4a1 1 0 01-1-1v-4.91a12.083 12.083 0 012.84-3.512L12 14z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-white leading-tight">Panel Admin</p>
                <p class="text-xs text-skblue-300 truncate">{{ $schoolName ?? \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}</p>
            </div>
            <button type="button" id="sidebarCloseBtn" class="ml-auto md:hidden text-skblue-300 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.dashboard')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p class="px-3.5 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-skblue-400/80">CMS</p>

            <a href="{{ route('admin.cms.gallery.index') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.cms.gallery.*')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                Galeri Foto
            </a>
            <a href="{{ route('admin.cms.news.index') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.cms.news.*')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Berita
            </a>
            <!-- <a href="{{ route('admin.cms.pages.index') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.cms.pages.*')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Halaman
            </a> -->
            <a href="{{ route('admin.cms.announcements.index') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.cms.announcements.*')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Pengumuman
            </a>
            @if($isSuperAdmin)
                <a href="{{ route('admin.cms.settings.index') }}"
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.cms.settings.*')) }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan Situs
                </a>
            @endif

            <p class="px-3.5 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-skblue-400/80">PPDB</p>

            <a href="{{ route('admin.ppdb.applicants.index') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.ppdb.applicants.*')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/></svg>
                Pendaftar
            </a>
            <a href="{{ route('admin.ppdb.verification.index') }}"
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.ppdb.verification.*')) }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Verifikasi Berkas
            </a>

            @if($isSuperAdmin)
                <p class="px-3.5 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-skblue-400/80">Khusus Super Admin</p>

                <a href="{{ route('admin.auth.users.index') }}"
                   class="group flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.auth.users.*')) }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Kelola Pengguna
                    </span>
                    <svg class="w-3.5 h-3.5 text-skblue-300/70 group-hover:text-skblue-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </a>
                <a href="{{ route('admin.auth.roles.index') }}"
                   class="group flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ $navClass(request()->routeIs('admin.auth.roles.*')) }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Kelola Role &amp; Izin
                    </span>
                    <svg class="w-3.5 h-3.5 text-skblue-300/70 group-hover:text-skblue-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </a>
            @endif
        </nav>

        <div class="px-4 py-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3 px-1">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-skblue-400 to-skblue-600 shadow-[0_0_14px_rgba(96,165,250,0.5)] flex items-center justify-center text-white text-xs font-bold shrink-0">
                    {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ $user->name ?? '-' }}</p>
                    <p class="text-[11px] text-skblue-400 truncate">{{ $isSuperAdmin ? 'Super Admin' : ($user?->role?->name ?? 'Admin') }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 text-xs font-semibold text-skblue-300 hover:text-white hover:bg-white/5 hover:shadow-[0_0_14px_rgba(96,165,250,0.3)] rounded-lg py-2 transition-all duration-300">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white/80 backdrop-blur-md border-b border-skblue-100 px-4 md:px-6 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button type="button" id="sidebarOpenBtn" class="md:hidden w-9 h-9 rounded-lg border border-skblue-200 flex items-center justify-center text-skblue-700 hover:bg-skblue-50 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="font-bold text-lg text-skblue-900">@yield('title', 'Admin')</h1>
            </div>
            <a href="{{ route('home') }}" target="_blank"
               class="text-xs font-semibold text-skblue-600 hover:text-white bg-skblue-50 hover:bg-skblue-600 border border-skblue-200 hover:border-skblue-600 rounded-full px-3.5 py-2 transition-all duration-300 flex items-center gap-1.5">
                Lihat Situs
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </header>

        <main class="flex-1 p-4 md:p-6">
            @if(session('success'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('sidebarOpenBtn');
        const closeBtn = document.getElementById('sidebarCloseBtn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
    });
</script>
</body>
</html>