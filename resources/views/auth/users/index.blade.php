@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <div>
            <h2 class="font-semibold text-skblue-900">Kelola Pengguna</h2>
            <p class="text-sm text-slate-500 mt-1">Atur akun dan hak akses pengguna panel admin.</p>
        </div>
        <a href="{{ route('admin.auth.users.create') }}"
           class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-5 py-2.5 transition">
            Tambah Pengguna
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-skblue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-skblue-50 text-skblue-700 text-left">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Nama</th>
                        <th class="px-5 py-3 font-semibold">Email</th>
                        <th class="px-5 py-3 font-semibold">Role</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold">Dibuat</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-skblue-50">
                    @forelse ($users as $user)
                        <tr class="hover:bg-skblue-50/50 transition">
                            <td class="px-5 py-3 font-medium text-slate-700">{{ $user->name }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $user->email }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $user->role?->name ?? $user->role?->slug ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-green-50 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-500">{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.auth.users.edit', $user) }}"
                                       class="rounded-lg bg-skblue-50 hover:bg-skblue-100 text-skblue-700 px-3 py-2 text-xs font-semibold transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.auth.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 text-xs font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-sm">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
