@extends('layouts.admin')

@section('title', 'Periode PPDB')

@section('content')

@php
    $today = now()->startOfDay();

    $currentPeriod = $periods->first(function ($period) use ($today) {
        return $period->is_active
            && (!$period->start_date || $today->gte($period->start_date))
            && (!$period->end_date || $today->lte($period->end_date));
    });

    $upcomingPeriod = $periods->first(function ($period) use ($today) {
        return $period->is_active
            && $period->start_date
            && $today->lt($period->start_date);
    });

    $endedActivePeriod = $periods->first(function ($period) use ($today) {
        return $period->is_active
            && $period->end_date
            && $today->gt($period->end_date);
    });
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-skblue-900">
                Periode PPDB
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Kelola periode pendaftaran peserta didik baru.
            </p>
        </div>

        <button
            type="button"
            onclick="openAddModal()"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl
                   bg-skblue-600 text-white text-sm font-semibold
                   hover:bg-skblue-700 transition shadow-sm"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Tambah Periode
        </button>

    </div>


    {{-- Alert --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>

                {{ session('success') }}
            </div>
        </div>
    @endif


    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>

                {{ session('error') }}
            </div>
        </div>
    @endif


    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            <p class="font-semibold mb-1">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- Status Periode PPDB --}}
    @if($currentPeriod)

        <div class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <div class="flex items-start gap-4">

                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-green-800">
                        Periode PPDB Sedang Berlangsung
                    </p>

                    <p class="text-lg font-bold text-green-900 mt-1">
                        {{ $currentPeriod->name }}
                    </p>

                    <p class="text-sm text-green-700 mt-1">
                        {{ $currentPeriod->start_date?->format('d M Y') ?? '-' }}
                        —
                        {{ $currentPeriod->end_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>

            </div>
        </div>

    @elseif($upcomingPeriod)

        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
            <div class="flex items-start gap-4">

                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-blue-800">
                        Periode PPDB Akan Dibuka
                    </p>

                    <p class="text-lg font-bold text-blue-900 mt-1">
                        {{ $upcomingPeriod->name }}
                    </p>

                    <p class="text-sm text-blue-700 mt-1">
                        {{ $upcomingPeriod->start_date?->format('d M Y') ?? '-' }}
                        —
                        {{ $upcomingPeriod->end_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>

            </div>
        </div>

    @elseif($endedActivePeriod)

        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">
            <div class="flex items-start gap-4">

                <div class="w-11 h-11 rounded-xl bg-yellow-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 011.73 3z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-yellow-800">
                        Periode PPDB Telah Berakhir
                    </p>

                    <p class="text-lg font-bold text-yellow-900 mt-1">
                        {{ $endedActivePeriod->name }}
                    </p>

                    <p class="text-sm text-yellow-700 mt-1">
                        Periode berakhir pada
                        {{ $endedActivePeriod->end_date?->format('d M Y') ?? '-' }}.
                        Silakan nonaktifkan periode ini.
                    </p>
                </div>

            </div>
        </div>

    @else

        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">
            <div class="flex items-start gap-4">

                <div class="w-11 h-11 rounded-xl bg-yellow-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 001.73 3z"/>
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-yellow-800">
                        Belum ada periode PPDB yang aktif.
                    </p>

                    <p class="text-sm text-yellow-700 mt-1">
                        Pendaftaran PPDB belum dapat dilakukan oleh calon peserta didik.
                    </p>
                </div>

            </div>
        </div>

    @endif


    {{-- Daftar Periode --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100">

            <div class="flex items-center justify-between">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Daftar Periode
                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Riwayat dan pengaturan periode PPDB.
                    </p>
                </div>

                <span class="px-3 py-1 rounded-full bg-skblue-50 text-skblue-700 text-xs font-semibold">
                    {{ $periods->count() }} Periode
                </span>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr class="text-left text-xs uppercase tracking-wide text-slate-500">

                        <th class="px-6 py-4 text-center w-16">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Nama Periode
                        </th>

                        <th class="px-6 py-4">
                            Tanggal Mulai
                        </th>

                        <th class="px-6 py-4">
                            Tanggal Berakhir
                        </th>

                        <th class="px-6 py-4 text-center">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($periods as $index => $period)

                        @php
                            $isStarted = !$period->start_date || $today->gte($period->start_date);
                            $isEnded = $period->end_date && $today->gt($period->end_date);
                        @endphp

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 text-center text-slate-500">
                                {{ $index + 1 }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold text-slate-800">
                                    {{ $period->name }}
                                </div>

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $period->start_date?->format('d M Y') ?? '-' }}

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $period->end_date?->format('d M Y') ?? '-' }}

                            </td>


                            <td class="px-6 py-4 text-center">

                                @if($period->is_active && !$isEnded && $isStarted)

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                 bg-green-100 text-green-700 text-xs font-semibold">

                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>

                                        Aktif

                                    </span>

                                @elseif($period->is_active && !$isStarted)

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                 bg-blue-100 text-blue-700 text-xs font-semibold">

                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>

                                        Akan Dibuka

                                    </span>

                                @elseif($isEnded)

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                 bg-slate-100 text-slate-600 text-xs font-semibold">

                                        Ditutup

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                 bg-slate-100 text-slate-600 text-xs font-semibold">

                                        Ditutup

                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        onclick="openEditModal(
                                            {{ $period->id }},
                                            @js($period->name),
                                            @js($period->start_date?->format('Y-m-d')),
                                            @js($period->end_date?->format('Y-m-d')),
                                            {{ $period->is_active ? 'true' : 'false' }}
                                        )"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg
                                               border border-skblue-200 text-skblue-700
                                               hover:bg-skblue-50 text-xs font-semibold transition"
                                    >

                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>

                                        Edit

                                    </button>


                                    {{-- Buka / Tutup --}}
                                    <form
                                        action="{{ route('admin.ppdb.periods.update', $period) }}"
                                        method="POST"
                                        class="inline"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="name" value="{{ $period->name }}">
                                        <input
                                            type="hidden"
                                            name="start_date"
                                            value="{{ $period->start_date?->format('Y-m-d') }}"
                                        >
                                        <input
                                            type="hidden"
                                            name="end_date"
                                            value="{{ $period->end_date?->format('Y-m-d') }}"
                                        >

                                        @if($period->is_active)

                                            <input type="hidden" name="is_active" value="0">

                                            <button
                                                type="submit"
                                                onclick="return confirm('Tutup periode {{ $period->name }}?')"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg
                                                       border border-red-200 text-red-600
                                                       hover:bg-red-50 text-xs font-semibold transition"
                                            >

                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"
                                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>

                                                Tutup

                                            </button>

                                        @else

                                            <input type="hidden" name="is_active" value="1">

                                            <button
                                                type="submit"
                                                onclick="return confirm('Buka periode {{ $period->name }}?')"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg
                                                       border border-green-200 bg-white text-green-600
                                                       hover:bg-green-50 hover:border-green-300
                                                       text-xs font-semibold transition"
                                            >

                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"
                                                          d="M7 11V7a5 5 0 0110 0v2m-8 2h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2zm8 0V9a3 3 0 00-6 0"/>
                                                </svg>

                                                Buka

                                            </button>

                                        @endif

                                    </form>

                                {{-- Hapus --}}
                                <form
                                    action="{{ route('admin.ppdb.periods.destroy', $period) }}"
                                    method="POST"
                                    class="inline"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Yakin ingin menghapus periode {{ $period->name }}?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg
                                            border border-red-200 bg-white text-red-600
                                            hover:bg-red-50 hover:border-red-300
                                            text-xs font-semibold transition"
                                        title="Hapus periode"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"
                                              d="M8 2v4m8-4v4M3 10h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-slate-700">
                                    Belum ada periode PPDB
                                </p>
                                <p class="text-sm text-slate-500 mt-1">
                                    Tambahkan periode untuk memulai pengaturan PPDB.
                                </p>
                            </div>
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL TAMBAH --}}
{{-- ========================================================= --}}

<div
    id="addPeriodModal"
    class="hidden fixed inset-0 z-[100] items-center justify-center p-4"
>

    <div
        class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
        onclick="closeAddModal()"
    ></div>


    <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl">

        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">

            <div>
                <h3 class="text-lg font-bold text-slate-800">
                    Tambah Periode PPDB
                </h3>

                <p class="text-xs text-slate-500 mt-1">
                    Buat periode pendaftaran baru.
                </p>
            </div>

            <button
                type="button"
                onclick="closeAddModal()"
                class="w-9 h-9 rounded-lg hover:bg-slate-100 text-slate-500"
            >
                ✕
            </button>

        </div>


        <form
            action="{{ route('admin.ppdb.periods.store') }}"
            method="POST"
        >

            @csrf

            <div class="p-6 space-y-5">

                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Periode
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Contoh: 2027/2028"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-skblue-200 focus:border-skblue-500"
                    >

                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-skblue-200 focus:border-skblue-500"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Berakhir
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-skblue-200 focus:border-skblue-500"
                        >

                    </div>

                </div>


                <div class="rounded-xl bg-blue-50 border border-blue-100 px-4 py-3">

                    <p class="text-xs text-blue-700">
                        Periode baru akan dibuat dalam kondisi
                        <strong>Ditutup</strong>.
                        Admin dapat membukanya setelah periode dibuat.
                    </p>

                </div>

            </div>


            <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100">

                <button
                    type="button"
                    onclick="closeAddModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200
                           text-slate-600 text-sm font-semibold hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-4 py-2.5 rounded-xl bg-skblue-600 text-white
                           text-sm font-semibold hover:bg-skblue-700"
                >
                    Tambah Periode
                </button>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL EDIT --}}
{{-- ========================================================= --}}

<div
    id="editPeriodModal"
    class="hidden fixed inset-0 z-[100] items-center justify-center p-4"
>

    <div
        class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
        onclick="closeEditModal()"
    ></div>


    <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl">

        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">

            <div>
                <h3 class="text-lg font-bold text-slate-800">
                    Edit Periode PPDB
                </h3>

                <p class="text-xs text-slate-500 mt-1">
                    Perbarui informasi periode.
                </p>
            </div>

            <button
                type="button"
                onclick="closeEditModal()"
                class="w-9 h-9 rounded-lg hover:bg-slate-100 text-slate-500"
            >
                ✕
            </button>

        </div>


        <form id="editPeriodForm" method="POST">

            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">

                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Periode
                    </label>

                    <input
                        type="text"
                        id="editName"
                        name="name"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-skblue-200 focus:border-skblue-500"
                    >

                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            id="editStartDate"
                            name="start_date"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-skblue-200 focus:border-skblue-500"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Berakhir
                        </label>

                        <input
                            type="date"
                            id="editEndDate"
                            name="end_date"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-skblue-200 focus:border-skblue-500"
                        >

                    </div>

                </div>


                <label class="flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        id="editActive"
                        name="is_active"
                        value="1"
                        class="w-4 h-4 rounded border-slate-300 text-skblue-600 focus:ring-skblue-500"
                    >

                    <span class="text-sm font-medium text-slate-700">
                        Aktifkan periode ini
                    </span>

                </label>

            </div>


            <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200
                           text-slate-600 text-sm font-semibold hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-4 py-2.5 rounded-xl bg-skblue-600 text-white
                           text-sm font-semibold hover:bg-skblue-700"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    function openAddModal() {
        const modal = document.getElementById('addPeriodModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAddModal() {
        const modal = document.getElementById('addPeriodModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }


    function openEditModal(id, name, startDate, endDate, isActive) {

        const modal = document.getElementById('editPeriodModal');

        const form = document.getElementById('editPeriodForm');

        document.getElementById('editName').value = name ?? '';
        document.getElementById('editStartDate').value = startDate ?? '';
        document.getElementById('editEndDate').value = endDate ?? '';
        document.getElementById('editActive').checked = isActive;

        form.action = "{{ url('/admin/ppdb/periods') }}/" + id;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeEditModal() {

        const modal = document.getElementById('editPeriodModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }


    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            closeAddModal();
            closeEditModal();

        }

    });

</script>

@endsection