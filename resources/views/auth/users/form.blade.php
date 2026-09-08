@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div>
                    <h2 class="font-semibold text-skblue-900">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h2>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi informasi akun pengguna.</p>
                </div>
                <a href="{{ route('admin.auth.users.index') }}" class="text-sm font-semibold text-skblue-600 hover:text-skblue-800">Kembali</a>
            </div>

            <form action="{{ isset($user) ? route('admin.auth.users.update', $user) : route('admin.auth.users.store') }}" method="POST" class="space-y-5">
                @csrf
                @isset($user)
                    @method('PUT')
                @endisset

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama</label>
                    <input id="name" type="text" name="name" required value="{{ old('name', $user->name ?? '') }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                    <input id="email" type="email" name="email" required value="{{ old('email', $user->email ?? '') }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-600 mb-1">Nomor HP</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-slate-600 mb-1">Role</label>
                    <select id="role_id" name="role_id"
                            class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        <option value="">Tanpa Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                                {{ $role->name ?? $role->slug }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-600 mb-1">Password {{ isset($user) ? '(opsional)' : '' }}</label>
                    <input id="password" type="password" name="password" {{ isset($user) ? '' : 'required' }} minlength="8"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                @isset($user)
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active))
                               class="rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400">
                        Akun aktif
                    </label>
                @endisset

                <button type="submit" class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                    {{ isset($user) ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
                </button>
            </form>
        </div>
    </div>
@endsection
