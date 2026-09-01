<section class="page-header">
  <div class="blueprint-grid"></div>
  <div class="wrap page-header-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Beranda</a>
      <i class="fa-solid fa-chevron-right"></i>
      @if(isset($crumb))
        <a href="{{ $crumbUrl ?? '#' }}">{{ $crumb }}</a>
        <i class="fa-solid fa-chevron-right"></i>
      @endif
      <span>{{ $title }}</span>
    </div>
    <div class="eyebrow" style="color:var(--gold-300);">{{ $eyebrow ?? 'SMK Negeri 1 Sebulu' }}</div>
    <h1>{{ $title }}</h1>
    @if(isset($subtitle))
      <p class="page-header-sub">{{ $subtitle }}</p>
    @endif
  </div>
</section>
