@extends('layouts.public')

@section('title', 'Pendaftaran — Pilih Jurusan')

@section('content')

    @include('ppdb.wizard._progress', ['currentStep' => 7])

    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="font-display font-extrabold text-2xl text-slate-800 mb-1">Pilih Jurusan</h1>
        <p class="text-sm text-slate-500 mb-6">Langkah 7 dari 7 — urutkan sesuai prioritas. Ini langkah terakhir sebelum pendaftaran Anda dikirim.</p>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm px-5 py-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('ppdb.wizard.submit') }}" method="POST" class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            @csrf

            <div class="space-y-5">
                @foreach([1] as $order)
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">
                            Pilihan {{ $order }}
                        </label>
                        <select name="major_choice_{{ $order }}" {{ $order === 1 ? 'required' : '' }}
                                class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                            <option value="">— Pilih Jurusan —</option>

                            @foreach($majors as $major)
                                <option value="{{ $major->id }}" {{ old('major_choice_'.$order, $recommendedSlug === $major->slug ? $major->id : null) == $major->id ? 'selected' : '' }}>
                                    {{ $major->code }} — {{ $major->name }}
                                    {{ $major->slug === $recommendedSlug ? ' (Direkomendasikan)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('ppdb.wizard.recommendation') }}"
                   class="rounded-xl border border-skblue-200 text-skblue-700 font-semibold px-6 py-3.5 hover:bg-skblue-50 transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="flex-1 rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3.5 shadow-md transition-all duration-200">
                    Kirim Pendaftaran
                </button>
            </div>
        </form>
    </section>

@endsection