@extends('layouts.admin')

@section('title', 'Pendaftar PPDB')

@section('content')

    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <h2 class="font-semibold text-skblue-900">Semua Pendaftar ({{ $applicants->total() }})</h2>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pendaftar..."
                   class="rounded-full border border-skblue-200 px-4 py-2 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none w-56">
            <button type="submit" class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-4 py-2 transition">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-skblue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-skblue-50 text-skblue-700 text-left">
                    <tr>
                        <th class="px-5 py-3 font-semibold">No. Pendaftaran</th>
                        <th class="px-5 py-3 font-semibold">Nama</th>
                        <th class="px-5 py-3 font-semibold">Jurusan Pilihan</th>
                        <th class="px-5 py-3 font-semibold">No. HP</th>
                        <th class="px-5 py-3 font-semibold">Berkas</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-skblue-50">
                    @forelse($applicants as $item)
                        <tr class="hover:bg-skblue-50/50 transition">
                            @php
                                $ppdbRegistration = $item->ppdbRegistration;
                                $majorChoice = $ppdbRegistration?->majorChoices->first()?->major?->name;
                                $phone = $item->phone
                                    ?: ($ppdbRegistration?->parentData?->father_phone
                                        ?: $ppdbRegistration?->parentData?->mother_phone);
                                $status = $ppdbRegistration?->status ?? $item->registration?->status ?? 'pending';
                                $statusMap = [
                                    'draft' => ['Draft', 'bg-slate-100 text-slate-600'],
                                    'submitted' => ['Menunggu', 'bg-amber-50 text-amber-700'],
                                    'documents_invalid' => ['Berkas Ditolak', 'bg-red-50 text-red-700'],
                                    'verified' => ['Terverifikasi', 'bg-skblue-50 text-skblue-700'],
                                    'accepted' => ['Diterima', 'bg-green-50 text-green-700'],
                                    'rejected' => ['Ditolak', 'bg-red-50 text-red-700'],
                                    'pending' => ['Menunggu', 'bg-amber-50 text-amber-700'],
                                ];
                            @endphp
                            <td class="px-5 py-3 text-slate-500 font-mono text-xs">{{ $item->registration_number }}</td>
                            <td class="px-5 py-3 font-medium text-slate-700">{{ $item->full_name }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $majorChoice ?: ($item->chosen_major ?: '—') }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $phone ?: '—' }}</td>
                            <td class="px-5 py-3 text-slate-500">
                                @if ($ppdbRegistration?->documents->isNotEmpty())
                                    <div class="flex flex-col gap-1">
                                        @foreach ($ppdbRegistration->documents as $document)
                                            <a href="{{ url('/storage/' . ltrim($document->file_path, '/')) }}" target="_blank" rel="noopener"
                                               class="text-xs font-semibold text-skblue-600 hover:text-skblue-800 hover:underline">
                                                {{ $document->document_type ?: $document->file_name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center rounded-full text-xs font-semibold px-2.5 py-1 {{ $statusMap[$status][1] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $statusMap[$status][0] ?? $status }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <form action="{{ route('admin.ppdb.applicants.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data pendaftar ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition ml-auto" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-slate-400 text-sm">Belum ada pendaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $applicants->appends(request()->query())->links() }}</div>

@endsection