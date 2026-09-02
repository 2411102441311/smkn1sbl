@extends('layouts.app')

@section('title', 'Program Keahlian — ' . $schoolName)
@section('description', 'Daftar program keahlian (jurusan) yang tersedia di ' . $schoolName . '.')

@section('content')

  @include('partials.page-header', [
      'title' => 'Program Keahlian',
      'eyebrow' => 'Jurusan Kami',
      'subtitle' => $schoolName . ' memiliki beberapa program keahlian unggulan yang dirancang sesuai kebutuhan dunia kerja dan industri.',
  ])

  <section class="jurusan section-pad" style="background:var(--paper);">
    <div class="wrap">
      <div class="section-head reveal">
        <div class="eyebrow">Program Keahlian</div>
        <h2>Pilih Jurusan Sesuai Minatmu</h2>
        <p>Klik salah satu jurusan untuk melihat detail kompetensi, fasilitas, dan prospek kerjanya.</p>
      </div>

      @php
        // Warna --bar dirotasi per kartu biar variatif (dibaca .jur-card::before dan .jur-icon di app.css)
        $barColors = ['var(--green-600)', 'var(--gold-600)', 'var(--navy-700)'];
        $iconMap = ['network' => 'network-wired', 'briefcase' => 'briefcase', 'leaf' => 'leaf'];
      @endphp

      <div class="jurusan-grid">
        @foreach($majors as $i => $m)
          @php
            $bar = $barColors[$i % count($barColors)];
            $faIcon = $iconMap[$m['icon']] ?? 'graduation-cap';
          @endphp
          <a href="{{ route('jurusan.show', $m['slug']) }}" class="jur-card reveal" style="--bar:{{ $bar }};">
            <span class="jur-num">SPEK. {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ $m['code'] }}</span>
            <div class="jur-icon"><i class="fa-solid fa-{{ $faIcon }}"></i></div>
            <h3>{{ $m['name'] }}</h3>
            <p>{{ $m['desc'] }}</p>
            <span class="more">Lihat Detail <i class="fa-solid fa-arrow-right"></i></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  @include('partials.cta-spmb')

@endsection