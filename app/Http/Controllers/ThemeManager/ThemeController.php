<?php

namespace App\Http\Controllers\ThemeManager;

use App\Http\Controllers\Controller;
use App\Models\ThemeManager\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::latest()->get();
        return view('theme.themes.index', compact('themes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'hero_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('theme/hero', 'public');
        }

        Theme::create($data);

        return back()->with('success', 'Tema berhasil dibuat.');
    }

    public function update(Request $request, Theme $theme)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'hero_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('theme/hero', 'public');
        }

        $theme->update($data);

        return back()->with('success', 'Tema berhasil diperbarui.');
    }

    // Jadikan tema ini sebagai tema aktif di homepage
    public function activate(Theme $theme)
    {
        $theme->activate();
        return back()->with('success', "Tema \"{$theme->name}\" kini aktif di halaman depan.");
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();
        return back()->with('success', 'Tema berhasil dihapus.');
    }
}
