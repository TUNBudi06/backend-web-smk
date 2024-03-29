<?php

namespace App\Http\Controllers;

use App\Models\tb_artikel;
use App\Models\tb_category_artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $artikel = tb_artikel::orderBy('artikel_timestamp', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.artikel.index', [
            'menu_active' => 'artikel',
            'token' => $token,
            'artikel' => $artikel,
            'category_artikel' => tb_category_artikel::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.artikel.create', [
            'menu_active' => 'artikel',
            'artikel' => tb_category_artikel::all(),
            'token' => $token,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'artikel_title' => 'required',
            'artikel_level' => 'required',
            'id_category' => 'required',
            'artikel_text' => 'required',
            'artikel_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'artikel_thumbnail.max' => 'The image may not be greater than 10MB.',
        ]);

        // Simpan data ke tabel artikel
        $data = new tb_artikel();
        $data->artikel_title = $request->artikel_title;
        $data->artikel_level = $request->artikel_level;
        $data->id_category = $request->id_category;
        $data->artikel_text = $request->artikel_text;
        $data->artikel_viewer = $request->artikel_viewer;

        // Simpan gambar
        if ($request->hasFile('artikel_thumbnail')) {
            $file = $request->file('artikel_thumbnail');
            $imageName = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();
            $file->move('img/artikel', $imageName);
            $data->artikel_thumbnail = $imageName;
        }

        $data->save();

        return redirect()->route('artikel.index', ['token' => $token])->with('success', 'Data added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_artikel = $request->route("artikel");
        $token = $request->session()->get('token') ?? $request->input('token');
        $artikel = tb_artikel::findOrFail($id_artikel);
        $categories = tb_category_artikel::all();

        return view('admin.artikel.edit', [
            'menu_active' => 'artikel',
            'token' => $token,
            'artikel' => $artikel,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_artikel = $request->route("artikel");
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'artikel_title' => 'required',
            'artikel_level' => 'required',
            'id_category' => 'required',
            'artikel_text' => 'required',
            'artikel_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'artikel_thumbnail.max' => 'The image may not be greater than 10MB.',
        ]);

        // Simpan data ke tabel artikel
        $data = tb_artikel::findOrFail($id_artikel);
        $data->update([
            'artikel_title' => $request->artikel_title,
            'artikel_level' => $request->artikel_level,
            'id_category' => $request->id_category,
            'artikel_text' => $request->artikel_text,
            'artikel_viewer' => $request->artikel_viewer,
        ]);

        // Periksa apakah ada gambar yang diunggah
        if ($request->hasFile('artikel_thumbnail')) {
            $file = $request->file('artikel_thumbnail');
            $imageName = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();
            $file->move('img/artikel', $imageName);
            $data->artikel_thumbnail = $imageName;
            $data->save();
        }

        dd($data);


        return redirect()->route('artikel.index', ['token' => $token])->with('success', 'Data added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_artikel = $request->route("artikel");
        $token = $request->session()->get('token') ?? $request->input('token');

        $artikel = tb_artikel::findOrFail($id_artikel);
        $artikel->delete();

        return redirect()->route('artikel.index', ['token' => $request->token])->with('success', 'Data deleted successfully.');
    }
}
