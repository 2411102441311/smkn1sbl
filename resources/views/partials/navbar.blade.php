<header id="siteHeader">
  <div class="navwrap">
    <a href="{{ url('/') }}#top" class="brand">
      <svg viewBox="0 0 48 48" fill="none">
        <path d="M24 2 L45 12 V26 C45 37 36 44.5 24 47 C12 44.5 3 37 3 26 V12 Z" fill="#0d2847" stroke="#e3a635" stroke-width="1.5"/>
        <text x="24" y="30" text-anchor="middle" font-family="Poppins, sans-serif" font-weight="800" font-size="15" fill="#e3a635">S1</text>
      </svg>
      <span class="name">SMKN 1 Sebulu<small>Unggul · Kompeten · Berkarakter</small></span>
    </a>
    <nav class="links">
      <a href="{{ route('profil') }}" @class(['active-link' => request()->routeIs('profil')])>Profil</a>
      <a href="{{ route('jurusan.index') }}" @class(['active-link' => request()->routeIs('jurusan.*')])>Jurusan</a>
      <a href="{{ route('home') }}#berita">Berita</a>
      <a href="{{ route('home') }}#galeri">Galeri</a>
      <a href="{{ route('home') }}#pengumuman">Pengumuman</a>
      <a href="{{ route('home') }}#kontak">Kontak</a>
    </nav>
    <div class="nav-cta">
      <a href="{{ route('home') }}#kontak" class="btn btn-ghost" style="padding:10px 18px;font-size:.85rem;">Kontak</a>
      <a href="{{ route('home') }}#spmb" class="btn btn-gold" style="padding:10px 20px;font-size:.85rem;">Daftar PPDB</a>
      <button class="burger" id="burgerBtn"><i class="fa-solid fa-bars"></i></button>
    </div>
  </div>
</header>
