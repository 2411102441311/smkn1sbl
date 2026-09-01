<section class="fasilitas section-pad">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow">Sarana Sekolah</div>
      <h2>Fasilitas Penunjang Praktik</h2>
      <p>Ruang dan peralatan yang disiapkan agar teori langsung terhubung dengan praktik nyata.</p>
    </div>
    <div class="fas-grid">
      @foreach($fasilitas as $f)
        <div class="fas-item reveal">
          <i class="fa-solid {{ $f['icon'] }}"></i>
          <h4>{{ $f['title'] }}</h4>
        </div>
      @endforeach
    </div>
  </div>
</section>
