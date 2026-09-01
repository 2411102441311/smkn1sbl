{{--
    Partial ikon jurusan. Dipakai dengan @include('partials.major-icon', ['icon' => 'network', 'class' => 'w-5 h-5 text-white'])
    Tambah ikon baru dengan menambah case baru di sini kalau nanti ada jurusan baru dengan icon key baru.
--}}
@switch($icon ?? 'default')
    @case('network')
        <svg class="{{ $class ?? 'w-5 h-5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17H5a2 2 0 01-2-2V9a2 2 0 012-2h4m10 0h-4a2 2 0 00-2 2v10m6-10a2 2 0 012 2v6a2 2 0 01-2 2m-6-10V5a2 2 0 012-2h4a2 2 0 012 2v2"/>
            <circle cx="7" cy="12" r="1.5" fill="currentColor" stroke="none"/>
        </svg>
        @break

    @case('briefcase')
        <svg class="{{ $class ?? 'w-5 h-5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-3 0h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
        </svg>
        @break

    @case('leaf')
        <svg class="{{ $class ?? 'w-5 h-5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3a9 9 0 00-9 9c0 4.97 4.03 9 9 9 4.97 0 9-4.03 9-9M11 3c4.97 0 9 4.03 9 9M11 3S6 8 6 13s2 5 2 5m11-9s-5 2-8 5"/>
        </svg>
        @break

    @default
        <svg class="{{ $class ?? 'w-5 h-5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 14.09V19a1 1 0 01-1 1H4a1 1 0 01-1-1v-4.91a12.083 12.083 0 012.84-3.512L12 14z"/>
        </svg>
@endswitch