<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\tb_category_news;
use Illuminate\Http\Request;

class BeritaCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $news = tb_category_news::all();
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        return view('admin.categories.beritacategory.index', [
            'menu_active' => 'berita',
            'action' => $action,
            'news' => $news,
            'token' => $token,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'create';
        return view('admin.categories.beritacategory.index', compact('action', 'token'));
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
        tb_category_news::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('berita.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_category = $request->route("berita_category");
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $category = tb_category_news::findOrFail($id_category);
        $data = [
            'token' => $token,
            'category' => $category,
            'update' => $action,
        ];
        return redirect(route('berita.category.index',$token))->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        // Update data category
        $category = tb_category_news::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('berita.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_category = $request->route("berita/category");
        $token = $request->session()->get('token') ?? $request->input('token');

       $category = tb_category_news::findOrFail($id_category);
       $category->delete();

        return redirect()->route('berita.category.index', ['token' => $token])->with('success', 'Kategori berhasil dihapus.');
    }
}