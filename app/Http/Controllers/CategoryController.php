<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function kategori()
    {
        $categories = Category::all();

        return view('inventaris.kategori', compact('categories'));
    }

    public function show($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->load('product');
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

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);
        
        $validatedData = $request->validate([
            'category_name'   => ['required', 'max:50'],
        ]);

        $category->update($validatedData);

        return response()->json($category->refresh());
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
