<section class="galeri section-pad" id="galeri">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow">Dokumentasi</div>
      <h2>Galeri Kegiatan Sekolah</h2>
      <p>Momen praktik, perlombaan, dan keseharian siswa SMK Negeri 1 Sebulu.</p>
    </div>
    <div class="gal-grid">
      @foreach($galeri as $g)
        <div class="gal-item {{ $g['size'] }} reveal gal-{{ $g['color'] }}">
          <i class="fa-solid {{ $g['icon'] }}"></i>
          <div class="overlay"><span>{{ $g['label'] }}</span></div>
        </div>
      @endforeach
    </div>
  </div>
</section>
