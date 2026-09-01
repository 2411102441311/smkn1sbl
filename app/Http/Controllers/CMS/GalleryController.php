<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\CMS\Gallery;
use App\Models\CMS\Category;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')->latest()->paginate(20);
        $categories = Category::all();
        return view('cms.gallery.index', compact('galleries', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('cms.gallery.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:4096',
            'caption' => 'nullable|string',
        ]);

        $data['image_path'] = $request->file('image')->store('gallery', 'public');
        unset($data['image']);

        Gallery::create($data);

        return redirect()->route('admin.cms.gallery.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}