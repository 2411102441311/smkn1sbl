@extends('layouts.app')

@section('title', 'Jurusan — SMK Negeri 1 Sebulu')
@section('description', 'Daftar lengkap kompetensi keahlian (jurusan) yang tersedia di SMK Negeri 1 Sebulu.')

@section('content')

  @include('partials.page-header', ['title' => 'Kompetensi Keahlian', 'eyebrow' => 'Jurusan', 'subtitle' => 'Enam program keahlian yang dirancang bersama mitra industri agar lulusan siap kerja sejak hari pertama.'])

  <section class="section-pad" style="background:var(--cream);">
    <div class="wrap">
      <div class="jurusan-grid jurusan-grid-full">
        @foreach($jurusan as $j)
          <div class="jur-card reveal" style="--bar:var(--{{ $j['color'] }}-600)">
            <span class="jur-num">{{ $j['code'] }}</span>
            <div class="jur-icon"><i class="fa-solid {{ $j['icon'] }}"></i></div>
            <h3>{{ $j['title'] }}</h3>
            <p>{{ $j['desc'] }}</p>
            <div class="jur-prospek">
              @foreach(array_slice($j['prospek'], 0, 2) as $p)
                <span class="mini-tag">{{ $p }}</span>
              @endforeach
            </div>
            <a href="{{ route('jurusan.show', $j['slug']) }}" class="more">Lihat detail jurusan <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  @include('partials.cta-spmb')

@endsection
