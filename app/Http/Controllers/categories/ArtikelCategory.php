<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class ArtikelCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $articles = tb_pemberitahuan_category::where(['type' => 1])->get();
        $action = $_GET['action'] ?? '';
        //        return $request->session()->all();

        return view('admin.categories.artikelcategory.index', [
            'menu_active' => 'berita',
            'action' => $action,
            'articles' => $articles,
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

        return redirect()->route('artikel.category.index', $token)->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_color' => 'required',
        ]);

        $category = new tb_pemberitahuan_category;
        $category->pemberitahuan_category_name = $request->category_name;
        $category->pemberitahuan_category_color = $request->category_color;
        $category->type = 1;
        $category->save();

        return redirect()->route('artikel.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_category = $request->route('artikel_category');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $category = tb_pemberitahuan_category::where(['type' => 1])->findOrFail($id_category);
        $data = [
            'category' => $category,
            'update' => $action,
        ];

        return redirect()->route('artikel.category.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
        $artikel_category = $request->route('artikel_category');

        // Update data category
        $category = tb_pemberitahuan_category::where(['type' => 1])->findOrFail($artikel_category);
        $category->update([
            'pemberitahuan_category_name' => $request->category_name,
            'pemberitahuan_category_color' => $request->category_color,
            'type' => 1,
        ]);

        return redirect()->route('artikel.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_category = $request->route('artikel_category');
        $token = $request->session()->get('token') ?? $request->input('token');

        $category = tb_pemberitahuan_category::where(['type' => 1])->findOrFail($id_category);
        $category->delete();

        return redirect()->route('artikel.category.index', ['token' => $token])->with('success', 'Kategori berhasil dihapus.');
    }
}
