<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\CMS\News;
use App\Models\CMS\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->latest()->paginate(15);
        return view('cms.news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::where('type', 'news')->get();
        return view('cms.news.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['user_id'] = auth()->id();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.cms.news.index')->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function show(News $news)
    {
        return view('cms.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = Category::where('type', 'news')->get();
        return view('cms.news.form', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        if ($data['status'] === 'published' && $news->status !== 'published') {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.cms.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    }
}