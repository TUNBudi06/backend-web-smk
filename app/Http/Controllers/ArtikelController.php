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
            'artikel_title.required' => 'Kolom nama artikel harus diisi.',
            'artikel_level.required' => 'Kolom level artikel harus diisi.',
            'id_category.required' => 'Kolom kategori artikel harus diisi.',
            'artikel_text.required' => 'Kolom isi artikel harus diisi.',
            'artikel_thumbnail' => 'Kolom gambar wajib diisi',
            'artikel_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
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

        return redirect()->route('artikel.index', ['token' => $token])->with('success', 'Artikel baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_artikel = $request->route("artikel");
        $token = $request->session()->get('token') ?? $request->input('token');
        $artikel = tb_artikel::findOrFail($id_artikel);
        $categories = tb_category_artikel::all();

        return view('admin.artikel.show', [
            'menu_active' => 'artikel',
            'profile_active' => 'artikel',
            'token' => $token,
            'artikel' => $artikel,
            'categories' => $categories,
        ]);
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
            'artikel_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'artikel_title.required' => 'Kolom nama artikel harus diisi.',
            'artikel_level.required' => 'Kolom level artikel harus diisi.',
            'id_category.required' => 'Kolom kategori artikel harus diisi.',
            'artikel_text.required' => 'Kolom isi artikel harus diisi.',
            'artikel_thumbnail' => 'Kolom gambar wajib diisi',
            'artikel_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);
    
        $data = tb_artikel::findOrFail($id_artikel);

        if ($request->hasFile('artikel_thumbnail')) {
            // Hapus gambar sebelumnya jika ada
            if ($data->artikel_thumbnail !== null) {
                $oldImagePath = public_path('img/artikel/' . $data->artikel_thumbnail);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('artikel_thumbnail')->hashName();
            $request->file('artikel_thumbnail')->move('img/artikel', $imageName);
            $data->artikel_thumbnail = $imageName;
        }

    
        $data->update([
            'artikel_title' => $request->artikel_title,
            'artikel_level' => $request->artikel_level,
            'id_category' => $request->id_category,
            'artikel_text' => $request->artikel_text,
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->route('artikel.index', ['token' => $token])->with('success', 'Artikel berhasil diperbarui.');
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

        return redirect()->route('artikel.index', ['token' => $request->token])->with('success', 'Artikel berhasil dihapus');
    }
}
