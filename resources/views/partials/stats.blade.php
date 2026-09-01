<section class="stats-band">
  <div class="wrap stats-grid">
    @foreach($heroStats as $stat)
      <div class="cell reveal"><b>{{ $stat['value'] }}</b><span>{{ $stat['label'] }}</span></div>
    @endforeach
  </div>
</section>
