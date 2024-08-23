<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\tb_category_gallery;
use Illuminate\Http\Request;

class GalleryCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $gallerys = tb_category_gallery::all();
        $action = $_GET['action'] ?? '';
        //        return $request->session()->all();

        return view('admin.categories.gallerycategory.index', [
            'menu_active' => 'gallery',
            'action' => $action,
            'gallerys' => $gallerys,
            'token' => $token,
            'category' => $request->session()->get('category') ?? null,
            'action' => $request->session()->get('update') ?? false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'create';
        $data = [
            'update' => $action,
        ];

        return redirect()->route('gallery.category.index', $token)->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        // Simpan data kategori
        tb_category_gallery::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('gallery.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_category = $request->route('gallery_category');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $category = tb_category_gallery::findOrFail($id_category);
        $data = [
            'category' => $category,
            'update' => $action,
        ];

        return redirect()->route('gallery.category.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
        $gallery_category = $request->route('gallery_category');

        // Update data category
        $category = tb_category_gallery::findOrFail($gallery_category);
        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('gallery.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_category = $request->route('gallery_category');
        $token = $request->session()->get('token') ?? $request->input('token');

        $category = tb_category_gallery::findOrFail($id_category);
        $category->delete();

        return redirect()->route('gallery.category.index', ['token' => $token])->with('success', 'Kategori berhasil dihapus.');
    }
}
