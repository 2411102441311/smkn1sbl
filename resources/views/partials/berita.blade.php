<section class="berita section-pad" id="berita">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow">Info Sekolah</div>
      <h2>Berita &amp; Kegiatan Terbaru</h2>
      <p>Ikuti perkembangan kegiatan belajar, praktik, dan capaian siswa SMK Negeri 1 Sebulu.</p>
    </div>
    <div class="berita-grid">
      @foreach($berita as $b)
        <div class="berita-card reveal">
          <div class="berita-thumb thumb-{{ $b['color'] }}">
            <i class="fa-solid {{ $b['icon'] }}"></i>
            <div class="date"><b>{{ $b['day'] }}</b><span>{{ $b['month'] }}</span></div>
          </div>
          <div class="berita-body">
            <span class="berita-cat">{{ $b['category'] }}</span>
            <h3>{{ $b['title'] }}</h3>
            <p>{{ $b['excerpt'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
    <div class="section-foot-link reveal"><a href="#" class="btn btn-navy">Lihat Semua Berita <i class="fa-solid fa-arrow-right"></i></a></div>
  </div>
</section>
