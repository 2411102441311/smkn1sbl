@extends('layouts.admin')

@section('title', 'Laporan PPDB')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Laporan Pendaftar PPDB</h2>
                <p class="text-sm text-slate-500">Filter data pendaftar berdasarkan rentang tanggal, status, atau asal sekolah.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('reports.ppdb.pdf', request()->query()) }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                    PDF
                </a>
                <a href="{{ route('reports.ppdb.excel', request()->query()) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 transition">
                    Excel
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('reports.ppdb.index') }}" class="mt-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Dari</label>
                <input type="date" name="from" value="{{ request('from') }}"
                       class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Sampai</label>
                <input type="date" name="to" value="{{ request('to') }}"
                       class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="documents_valid" {{ request('status') == 'documents_valid' ? 'selected' : '' }}>Berkas Valid</option>
                    <option value="documents_invalid" {{ request('status') == 'documents_invalid' ? 'selected' : '' }}>Berkas Ditolak</option>
                    <option value="graded" {{ request('status') == 'graded' ? 'selected' : '' }}>Nilai Diproses</option>
                    <option value="recommended" {{ request('status') == 'recommended' ? 'selected' : '' }}>Direkomendasikan</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Asal Sekolah</label>
                <input type="text" name="school_origin" value="{{ request('school_origin') }}" placeholder="Cari asal sekolah"
                       class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                    Filter
                </button>
                <a href="{{ route('reports.ppdb.index') }}" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-center text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">No. Pendaftaran</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Asal Sekolah</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Pilihan 1</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Pilihan 2</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Pilihan 3</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Rekomendasi</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($registrations as $index => $registration)
                        @php
                            $choices = $registration->majorChoices;
                            $statusLabels = [
                                'draft' => 'Draft',
                                'submitted' => 'Menunggu Verifikasi',
                                'documents_valid' => 'Berkas Valid',
                                'documents_invalid' => 'Berkas Ditolak',
                                'graded' => 'Nilai Diproses',
                                'recommended' => 'Direkomendasikan',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-slate-600">{{ $registrations->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $registration->registration_number ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700 font-medium">{{ $registration->biodata->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $registration->biodata->school_origin ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ optional($choices->get(0))->major?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ optional($choices->get(1))->major?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ optional($choices->get(2))->major?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $registration->sawResult?->recommendedMajor?->name ?? 'Belum dihitung' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700">
                                    {{ $statusLabels[$registration->status] ?? ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $registration->created_at?->format('d-m-Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-10 text-center text-slate-500">
                                Belum ada data pendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
