<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $prodi = tb_prodi::get();
        $action = $_GET['action'] ?? '';
        //        return $request->session()->all();

        return view('admin.page.profile.prodi.index', [
            'menu_active' => 'jurusan',
            'action' => $action,
            'prodi' => $prodi,
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

        return redirect()->route('prodi.index', $token)->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prodi_name' => 'required',
            'prodi_short' => 'required',
            'prodi_color' => 'required',
        ]);

        $category = new tb_prodi();
        $category->prodi_name = $request->prodi_name;
        $category->prodi_short = $request->prodi_short;
        $category->prodi_color = $request->prodi_color;
        $category->save();

        return redirect()->route('prodi.index', ['token' => $request->token])->with('success', 'Prodi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_category = $request->route('prodi');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $category = tb_prodi::findOrFail($id_category);
        $data = [
            'category' => $category,
            'update' => $action,
        ];

        return redirect()->route('prodi.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'prodi_name' => 'required',
            'prodi_short' => 'required',
            'prodi_color' => 'required',
        ]);
        $prodi = $request->route('prodi');

        // Update data category
        $category = tb_prodi::findOrFail($prodi);
        $category->update([
            'prodi_name' => $request->prodi_name,
            'prodi_short' => $request->prodi_short,
            'prodi_color' => $request->prodi_color,
            'type' => 1,
        ]);

        return redirect()->route('prodi.index', ['token' => $request->token])->with('success', 'Prodi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_category = $request->route('prodi');
        $token = $request->session()->get('token') ?? $request->input('token');

        $category = tb_prodi::findOrFail($id_category);
        $category->delete();

        return redirect()->route('prodi.index', ['token' => $token])->with('success', 'Prodi berhasil dihapus.');
    }
}
