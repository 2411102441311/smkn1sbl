@extends('layouts.admin')

@section('title', 'Verifikasi Berkas')

@section('content')
    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <div>
            <h2 class="font-semibold text-skblue-900">Verifikasi Berkas</h2>
            <p class="text-sm text-slate-500 mt-1">Periksa dokumen pendaftar sebelum memvalidasi.</p>
        </div>
        <span class="rounded-full bg-amber-50 text-amber-700 px-3 py-1 text-sm font-semibold">
            {{ $registrations->total() }} menunggu
        </span>
    </div>

    <div class="bg-white rounded-2xl border border-skblue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-skblue-50 text-skblue-700 text-left">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Pendaftar</th>
                        <th class="px-5 py-3 font-semibold">Nomor Registrasi</th>
                        <th class="px-5 py-3 font-semibold">Asal Sekolah</th>
                        <th class="px-5 py-3 font-semibold">Dokumen</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-skblue-50">
                    @forelse($registrations as $registration)
                        <tr class="hover:bg-skblue-50/50 transition">
                            <td class="px-5 py-3 font-medium text-slate-700">
                                {{ $registration->biodata?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-slate-500 font-mono text-xs">
                                {{ $registration->registration_number }}
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ $registration->biodata?->school_origin ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ $registration->documents->count() }} berkas
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.ppdb.verification.store', $registration) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="valid">
                                        <button type="submit" class="rounded-lg bg-green-50 hover:bg-green-100 text-green-700 px-3 py-2 text-xs font-semibold transition">
                                            Valid
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.ppdb.verification.store', $registration) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="hidden" name="status" value="invalid">
                                        <input type="text" name="remarks" placeholder="Catatan" class="w-28 rounded-lg border border-slate-200 px-2 py-2 text-xs focus:border-skblue-400 focus:outline-none">
                                        <button type="submit" class="rounded-lg bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 text-xs font-semibold transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-sm">Tidak ada berkas yang menunggu verifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $registrations->links() }}</div>
@endsection
