<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'SMK Negeri 1 Sebulu — Unggul, Kompeten, Berkarakter')</title>
<meta name="description" content="@yield('description', 'Website resmi SMK Negeri 1 Sebulu — informasi PPDB, jurusan, berita, dan kegiatan sekolah.')">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

@include('partials.navbar')

<main>
    @yield('content')
</main>

@include('partials.footer')

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
