<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Auth\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);
        return view('auth.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('auth.users.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'phone' => 'nullable|string|max:30',
        ]);

        // Password TIDAK di-Hash::make() di sini — model User.php sudah punya
        // cast 'password' => 'hashed' yang otomatis meng-hash saat disimpan.
        User::create($data);

        return redirect()->route('auth.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('auth.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'boolean',
        ]);

        if (empty($data['password'])) {
            unset($data['password']); // jangan timpa password lama kalau field dikosongkan
        }
        // Kalau diisi, biarkan apa adanya (plain text) — cast 'hashed' di model
        // yang akan otomatis meng-hash-nya saat disimpan.

        $user->update($data);

        return redirect()->route('auth.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}