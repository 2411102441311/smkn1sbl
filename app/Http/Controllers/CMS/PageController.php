<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\CMS\Page;
use App\Models\CMS\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('category')->latest()->paginate(15);
        return view('cms.pages.index', compact('pages'));
    }

    public function create()
    {
        $categories = Category::where('type', 'page')->get();
        return view('cms.pages.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.cms.pages.index')->with('success', 'Halaman berhasil dibuat.');
    }

    public function show(Page $page)
    {
        return view('cms.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $categories = Category::where('type', 'page')->get();
        return view('cms.pages.form', compact('page', 'categories'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.cms.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Halaman berhasil dihapus.');
    }
}