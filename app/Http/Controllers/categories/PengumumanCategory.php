<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class PengumumanCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $request->input('show', 10);
        $token = $request->session()->get('token') ?? $request->input('token');
        $pengumuman = tb_pemberitahuan_category::where(['type' => 2])->paginate($perpage);
        $count = tb_pemberitahuan_category::where(['type' => 2])->count();
        $action = $_GET['action'] ?? '';

        return view('admin.categories.pengumumancategory.index', [
            'menu_active' => 'pengumuman',
            'action' => $action,
            'pengumuman' => $pengumuman,
            'token' => $token,
            'category' => $request->session()->get('category') ?? null,
            'action' => $request->session()->get('update') ?? false,
            'count' => $count,
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

        return redirect()->route('pengumuman.category.index', $token)->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $category = new tb_pemberitahuan_category;
            $category->pemberitahuan_category_name = $request->category_name;
            $category->pemberitahuan_category_color = $request->category_color;
            $category->type = 2;
            $category->save();

            return redirect()->route('pengumuman.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan kategori: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_category = $request->route('pengumuman_category');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $category = tb_pemberitahuan_category::where(['type' => 2])->findOrFail($id_category);
        $data = [
            'category' => $category,
            'update' => $action,
        ];

        return redirect()->route('pengumuman.category.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $pengumuman_category = $request->route('pengumuman_category');

        // Update data category
        $category = tb_pemberitahuan_category::where(['type' => 2])->findOrFail($pengumuman_category);
        $category->update([
            'pemberitahuan_category_name' => $request->category_name,
            'pemberitahuan_category_color' => $request->category_color,
            'type' => 2,
        ]);

        return redirect()->route('pengumuman.category.index', ['token' => $request->token])->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_category = $request->route('pengumuman_category');
        $token = $request->session()->get('token') ?? $request->input('token');

        $category = tb_pemberitahuan_category::where(['type' => 2])->findOrFail($id_category);
        $category->delete();

        return redirect()->route('pengumuman.category.index', ['token' => $token])->with('success', 'Kategori berhasil dihapus.');
    }
}
