<div class="ticker-bar">
  <div class="ticker-track" id="tickerTrack">
    @foreach(array_merge($ticker, $ticker) as $item)
      <span><i class="fa-solid fa-bullhorn"></i> {{ $item }}</span>
    @endforeach
  </div>
</div>
