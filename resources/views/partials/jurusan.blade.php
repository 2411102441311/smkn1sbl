<section class="jurusan section-pad" id="jurusan">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow">Kompetensi Keahlian</div>
      <h2>Enam Jurusan, Satu Standar Kompeten</h2>
      <p>Setiap program keahlian dirancang bersama mitra industri agar lulusan siap kerja sejak hari pertama.</p>
    </div>
    <div class="jurusan-grid">
      @foreach($jurusan as $j)
        <div class="jur-card reveal" style="--bar:var(--{{ $j['color'] }}-600)">
          <span class="jur-num">{{ $j['code'] }}</span>
          <div class="jur-icon"><i class="fa-solid {{ $j['icon'] }}"></i></div>
          <h3>{{ $j['title'] }}</h3>
          <p>{{ $j['desc'] }}</p>
          <a href="{{ route('jurusan.show', $j['slug']) }}" class="more">Lihat detail <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      @endforeach
    </div>
    <div class="section-foot-link reveal"><a href="{{ route('jurusan.index') }}" class="btn btn-navy">Lihat Semua Jurusan <i class="fa-solid fa-arrow-right"></i></a></div>
  </div>
</section>
