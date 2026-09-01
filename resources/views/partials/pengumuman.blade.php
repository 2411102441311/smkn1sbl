<section class="pengumuman section-pad" id="pengumuman">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow">Informasi Resmi</div>
      <h2>Pengumuman Sekolah</h2>
      <p>Informasi akademik dan kegiatan resmi terbaru dari SMK Negeri 1 Sebulu.</p>
    </div>
    <div class="peng-tabs reveal">
      <button class="active" data-filter="semua">Semua</button>
      <button data-filter="akademik">Akademik</button>
      <button data-filter="ppdb">PPDB</button>
      <button data-filter="kegiatan">Kegiatan</button>
    </div>
    <div class="peng-list">
      @foreach($pengumuman as $p)
        <div class="peng-row reveal" data-tag="{{ strtolower($p['tag']) }}">
          <div class="pdate"><b>{{ $p['day'] }}</b><span>{{ $p['month'] }}</span></div>
          <div class="ptext"><h4>{{ $p['title'] }}</h4><span>{{ $p['desc'] }}</span></div>
          <span class="ptag">{{ $p['tag'] }}</span>
          <i class="fa-solid fa-chevron-right arrow"></i>
        </div>
      @endforeach
    </div>
  </div>
</section>
