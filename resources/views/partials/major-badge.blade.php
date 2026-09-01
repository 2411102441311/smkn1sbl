{{--
    Badge lingkaran untuk jurusan — otomatis pakai LOGO ASLI kalau sudah diupload,
    kalau belum ada, otomatis fallback ke ikon SVG generik (biar gak pernah kosong/error).

    Cara pakai:
    @include('partials.major-badge', ['major' => $major, 'size' => 'lg'])

    Ukuran yang tersedia: 'md' (default, dipakai di kartu list) atau 'lg' (dipakai di halaman detail)
--}}
@php
    $badgeSize = $size ?? 'md';
    $sizeClasses = $badgeSize === 'lg' ? 'w-20 h-20' : 'w-14 h-14';
    $iconSizeClasses = $badgeSize === 'lg' ? 'w-9 h-9' : 'w-7 h-7';

    $logoPath = $major['logo'] ?? null;
    $logoExists = $logoPath && file_exists(public_path($logoPath));
@endphp

@if($logoExists)
    {{-- Logo asli sudah diupload: tampilkan dalam lingkaran putih (biar logo apapun warnanya tetap rapi) --}}
    <div class="{{ $sizeClasses }} rounded-2xl bg-white border border-skblue-100 shadow-md flex items-center justify-center shrink-0 p-2">
        <img src="{{ asset($logoPath) }}" alt="Logo {{ $major['name'] }}" class="w-full h-full object-contain">
    </div>
@else
    {{-- Logo belum diupload: fallback ke ikon SVG dengan latar gradasi warna jurusan --}}
    <div class="{{ $sizeClasses }} rounded-2xl bg-gradient-to-br {{ $major['color_from'] }} {{ $major['color_to'] }} shadow-md flex items-center justify-center shrink-0">
        @include('partials.major-icon', ['icon' => $major['icon'] ?? 'default', 'class' => $iconSizeClasses . ' text-white'])
    </div>
@endif