<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->paginate(30);
        return view('auth.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'module' => 'required|string|max:100',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Permission::create($data);

        return back()->with('success', 'Permission berhasil ditambahkan.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission berhasil dihapus.');
    }
}
