<section class="prestasi section-pad">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow" style="color:var(--gold-300);">Penghargaan</div>
      <h2>Prestasi Membanggakan</h2>
      <p>Capaian siswa dan sekolah dalam kompetisi akademik, keahlian, dan non-akademik.</p>
    </div>
    <div class="prestasi-scroll">
      @foreach($prestasi as $p)
        <div class="prestasi-card reveal">
          <div class="trophy"><i class="fa-solid {{ $p['icon'] }}"></i></div>
          <h4>{{ $p['title'] }}</h4>
          <p>{{ $p['desc'] }}</p>
          <span class="level">{{ $p['level'] }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>
