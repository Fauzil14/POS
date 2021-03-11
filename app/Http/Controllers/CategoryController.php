<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function kategori()
    {
        $categories = Category::get();

        return view('inventaris.kategori', compact('categories'));
    }

    public function show($category_id)
    {
        $category = Category::findOrFail($category_id);
        $categories = Category::get();

        return view('inventaris.detail-kategori', compact('category', 'categories'));
    }

    public function newCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|max:50'
        ]);

        $category = Category::create($validatedData);

        return response()->json($category);
    }

    public function delete($category_id)
    {
        $category = Category::findOrFail($category_id);

        try {
            $category->delete();
    
            Alert::success('Berhasil', 'Kategori produk berhasil di hapus');
            return redirect()->route('inventaris.kategori');
        } catch(\Throwable $e) {
            Alert::error('Gagal', 'Kategori produk gagal di hapus');
            return back();
        }
    }
}
