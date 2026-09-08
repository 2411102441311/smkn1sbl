@extends('layouts.admin')

@section('title', isset($role) ? 'Edit Role' : 'Tambah Role')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-2xl border border-skblue-100 p-6 md:p-8">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div>
                    <h2 class="font-semibold text-skblue-900">{{ isset($role) ? 'Edit Role' : 'Tambah Role' }}</h2>
                    <p class="text-sm text-slate-500 mt-1">Tentukan nama role dan izin yang dimilikinya.</p>
                </div>
                <a href="{{ route('admin.auth.roles.index') }}" class="text-sm font-semibold text-skblue-600 hover:text-skblue-800">Kembali</a>
            </div>

            <form action="{{ isset($role) ? route('admin.auth.roles.update', $role) : route('admin.auth.roles.store') }}" method="POST" class="space-y-5">
                @csrf
                @isset($role)
                    @method('PUT')
                @endisset

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama Role</label>
                    <input id="name" type="text" name="name" required value="{{ old('name', $role->name ?? '') }}"
                           class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                           placeholder="Contoh: Panitia PPDB">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-600 mb-1">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full rounded-lg border border-skblue-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:outline-none"
                              placeholder="Jelaskan fungsi role ini">{{ old('description', $role->description ?? '') }}</textarea>
                    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Permission</h3>
                    <div class="space-y-4">
                        @forelse ($permissions as $module => $modulePermissions)
                            <div class="rounded-xl border border-skblue-100 p-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-skblue-700 mb-3">{{ $module ?: 'Umum' }}</p>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    @foreach ($modulePermissions as $permission)
                                        <label class="flex items-start gap-2 text-sm text-slate-600">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                @checked(in_array($permission->id, old('permissions', isset($role) ? $role->permissions->pluck('id')->all() : [])))
                                                class="mt-0.5 rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400">
                                            <span>{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">Belum ada permission yang tersedia.</p>
                        @endforelse
                    </div>
                    @error('permissions') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    @error('permissions.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="rounded-full bg-skblue-600 hover:bg-skblue-700 text-white text-sm font-semibold px-6 py-2.5 transition">
                    {{ isset($role) ? 'Simpan Perubahan' : 'Simpan Role' }}
                </button>
            </form>
        </div>
    </div>
@endsection
