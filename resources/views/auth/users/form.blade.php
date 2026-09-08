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
                    <div class="relative">
                        <input id="password" type="password" name="password" {{ isset($user) ? '' : 'required' }} minlength="8"
                               class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 pr-11 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none">
                        <button type="button" id="togglePassword" aria-label="Tampilkan password"
                                class="absolute inset-y-0 right-0 px-3 text-slate-400 hover:text-skblue-600 transition">
                            <svg id="passwordEye" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
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

    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const password = document.getElementById('password');
            const isHidden = password.type === 'password';

            password.type = isHidden ? 'text' : 'password';
            this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
@endsection
