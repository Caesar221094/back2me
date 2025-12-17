<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('nama')->paginate(20);
        return view('back2me.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('back2me.admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
            'deskripsi' => 'nullable|string',
        ]);

        Category::create($request->only(['nama', 'deskripsi']));

        return redirect()->route('back2me.admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('back2me.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
            'deskripsi' => 'nullable|string',
        ]);

        $category->update($request->only(['nama', 'deskripsi']));

        return redirect()->route('back2me.admin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('back2me.admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
