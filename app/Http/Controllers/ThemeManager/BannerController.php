<?php

namespace App\Http\Controllers\ThemeManager;

use App\Http\Controllers\Controller;
use App\Models\ThemeManager\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with('theme')->orderBy('sort_order')->get();
        return view('theme.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'theme_id' => 'nullable|exists:themes,id',
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120',
            'link_url' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        $data['image_path'] = $request->file('image')->store('theme/banners', 'public');
        unset($data['image']);

        Banner::create($data);

        return back()->with('success', 'Banner berhasil ditambahkan.');
    }

    public function toggle(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return back()->with('success', 'Status banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus.');
    }
}
