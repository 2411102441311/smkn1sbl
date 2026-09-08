@extends('layouts.admin')

@section('title', 'Registrasi PPDB')

@section('content')

    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <h2 class="font-semibold text-skblue-900">Semua Registrasi ({{ $registrations->total() }})</h2>
        <form method="GET" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()" class="rounded-full border border-skblue-200 px-4 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="pending" @selected(request('status')==='pending')>Menunggu</option>
                <option value="verified" @selected(request('status')==='verified')>Terverifikasi</option>
                <option value="accepted" @selected(request('status')==='accepted')>Diterima</option>
                <option value="rejected" @selected(request('status')==='rejected')>Ditolak</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-skblue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-skblue-50 text-skblue-700 text-left">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Pendaftar</th>
                        <th class="px-5 py-3 font-semibold">Gelombang</th>
                        <th class="px-5 py-3 font-semibold">Tanggal Daftar</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-skblue-50">
                    @forelse($registrations as $item)
                        <tr class="hover:bg-skblue-50/50 transition">
                            <td class="px-5 py-3 font-medium text-slate-700">{{ $item->applicant?->full_name ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $item->wave }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $item->registration_date?->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3">
                                <form action="{{ route('admin.ppdb.registrations.update', $item) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="rounded-full border border-skblue-200 text-xs font-semibold px-2.5 py-1 focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                                        <option value="pending" @selected($item->status==='pending')>Menunggu</option>
                                        <option value="verified" @selected($item->status==='verified')>Terverifikasi</option>
                                        <option value="accepted" @selected($item->status==='accepted')>Diterima</option>
                                        <option value="rejected" @selected($item->status==='rejected')>Ditolak</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.ppdb.applicants.index', ['search' => $item->applicant?->full_name]) }}"
                                   class="text-xs font-semibold text-skblue-600 hover:text-skblue-800 transition">Lihat Pendaftar</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400 text-sm">Belum ada registrasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $registrations->appends(request()->query())->links() }}</div>

@endsection