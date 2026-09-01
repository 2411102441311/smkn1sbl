<section class="hero" id="top">
  <div class="blueprint-grid"></div>
  <div class="hero-inner">
    <div>
      <div class="eyebrow" style="color:var(--gold-300);"><span class="tag">PPDB 2026/2027 DIBUKA</span> Pendaftaran gelombang pertama</div>
      <h1>Menempa Keahlian, <em>Membentuk Karakter</em>, Membangun Masa Depan Sebulu.</h1>
      <p class="lead">SMK Negeri 1 Sebulu menyiapkan lulusan yang kompeten di bidangnya, siap kerja, siap usaha, dan siap melanjutkan pendidikan — dengan fasilitas praktik nyata dan pengajar berpengalaman.</p>
      <div class="hero-actions">
        <a href="#spmb" class="btn btn-gold">Info Pendaftaran <i class="fa-solid fa-arrow-right"></i></a>
        <a href="#jurusan" class="btn btn-ghost">Jelajahi Jurusan</a>
      </div>
      <div class="hero-stats">
        @foreach($heroStats as $stat)
          <div class="stat"><b>{{ $stat['value'] }}</b><span>{{ $stat['label'] }}</span></div>
        @endforeach
      </div>
    </div>
    <div class="hero-art">
      <div class="badge-card bracket">
        <span class="corner-tag">Kampus Utama</span>
        <svg class="building-illust" viewBox="0 0 380 300" fill="none">
          <rect x="40" y="120" width="300" height="150" rx="4" fill="#153a5e"/>
          <rect x="40" y="120" width="300" height="18" fill="#e3a635"/>
          <rect x="70" y="150" width="34" height="40" fill="#2a9962"/>
          <rect x="120" y="150" width="34" height="40" fill="#f2cd7c"/>
          <rect x="170" y="150" width="34" height="40" fill="#2a9962"/>
          <rect x="220" y="150" width="34" height="40" fill="#f2cd7c"/>
          <rect x="270" y="150" width="34" height="40" fill="#2a9962"/>
          <rect x="160" y="210" width="60" height="60" fill="#0d2847"/>
          <polygon points="30,120 190,60 350,120" fill="#1c7c4c"/>
          <rect x="185" y="30" width="10" height="34" fill="#0d2847"/>
          <path d="M190 20 L215 30 L190 34 Z" fill="#e3a635"/>
        </svg>
      </div>
      <div class="float-chip chip-1"><i class="fa-solid fa-award"></i> Terakreditasi A</div>
      <div class="float-chip chip-2"><i class="fa-solid fa-briefcase"></i> Mitra 20+ Industri</div>
    </div>
  </div>
  <div class="scroll-cue"><span>SCROLL</span><div class="line"></div></div>
</section>
