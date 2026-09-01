@extends('layouts.app')

@section('title', $jurusan['title'].' — SMK Negeri 1 Sebulu')
@section('description', $jurusan['desc'])

@section('content')

  @include('partials.page-header', [
      'title' => $jurusan['title'],
      'eyebrow' => $jurusan['code'],
      'subtitle' => $jurusan['desc'],
      'crumb' => 'Jurusan',
      'crumbUrl' => route('jurusan.index'),
  ])

  <section class="section-pad" style="background:var(--paper);">
    <div class="wrap jur-detail-grid">
      <div class="reveal">
        <div class="jur-icon" style="--bar:var(--{{ $jurusan['color'] }}-600);width:64px;height:64px;font-size:1.6rem;margin-bottom:22px;">
          <i class="fa-solid {{ $jurusan['icon'] }}"></i>
        </div>
        <h2 style="margin-bottom:16px;">Tentang Program Ini</h2>
        <p class="body-text">{{ $jurusan['deskripsi_panjang'] }}</p>

        <h3 style="margin:34px 0 16px;font-size:1.15rem;">Kompetensi yang Dipelajari</h3>
        <ul class="check-list">
          @foreach($jurusan['kompetensi'] as $k)
            <li><i class="fa-solid fa-circle-check"></i> {{ $k }}</li>
          @endforeach
        </ul>
      </div>

      <aside class="jur-side reveal">
        <div class="jur-side-card bracket">
          <h4><i class="fa-solid fa-building-columns"></i> Fasilitas Jurusan</h4>
          <ul class="side-list">
            @foreach($jurusan['fasilitas'] as $f)
              <li>{{ $f }}</li>
            @endforeach
          </ul>
        </div>
        <div class="jur-side-card">
          <h4><i class="fa-solid fa-briefcase"></i> Prospek Kerja</h4>
          <div class="chip-row">
            @foreach($jurusan['prospek'] as $p)
              <span class="chip">{{ $p }}</span>
            @endforeach
          </div>
        </div>
        <a href="{{ route('home') }}#spmb" class="btn btn-gold" style="width:100%;justify-content:center;">Daftar Jurusan Ini <i class="fa-solid fa-arrow-right"></i></a>
      </aside>
    </div>
  </section>

  @if(count($lainnya))
    <section class="section-pad" style="background:var(--cream-dim);">
      <div class="wrap">
        <div class="section-head reveal">
          <div class="eyebrow">Jurusan Lain</div>
          <h2>Lihat Kompetensi Keahlian Lainnya</h2>
        </div>
        <div class="jurusan-grid">
          @foreach($lainnya as $j)
            <div class="jur-card reveal" style="--bar:var(--{{ $j['color'] }}-600)">
              <span class="jur-num">{{ $j['code'] }}</span>
              <div class="jur-icon"><i class="fa-solid {{ $j['icon'] }}"></i></div>
              <h3>{{ $j['title'] }}</h3>
              <p>{{ $j['desc'] }}</p>
              <a href="{{ route('jurusan.show', $j['slug']) }}" class="more">Lihat detail <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  @include('partials.cta-spmb')

@endsection
