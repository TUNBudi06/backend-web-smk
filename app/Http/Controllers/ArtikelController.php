<?php

namespace App\Http\Controllers;

use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $artikel = tb_pemberitahuan::where(['type' => 1])
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.artikel.index', [
            'menu_active' => 'informasi',
            'info_active' => 'artikel',
            'token' => $token,
            'artikel' => $artikel,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.artikel.create', [
            'menu_active' => 'informasi',
            'info_active' => 'artikel',
            'artikel' => tb_pemberitahuan_category::where(['type' => 1])->get(),
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
            'nama' => 'required',
            'level' => 'required',
            'id_pemberitahuan_category' => 'required',
            'text' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama artikel harus diisi.',
            'level.required' => 'Kolom level artikel harus diisi.',
            'id_pemberitahuan_category.required' => 'Kolom kategori artikel harus diisi.',
            'text.required' => 'Kolom isi artikel harus diisi.',
            'thumbnail' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Simpan data ke tabel artikel
        $data = new tb_pemberitahuan;
        $data->nama = $request->nama;
        $data->level = $request->level;
        $data->category = $request->id_pemberitahuan_category;
        $data->text = $request->text;
        $data->approved = $request->session()->get('user')->role == 1 ? 1 : 0;
        $data->Approved_by = $request->session()->get('user')->name;
        $data->type = 1;
        $data->viewer = 0;

        // Simpan gambar
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $imageName = md5($file->getClientOriginalName().microtime()).'.'.$file->getClientOriginalExtension();
            $file->move('img/artikel', $imageName);
            $data->thumbnail = $imageName;
        }

        $data->save();

        return redirect()->route('artikel.index', ['token' => $token])->with('success', 'Artikel baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_artikel = $request->route('artikel');
        $token = $request->session()->get('token') ?? $request->input('token');
        $artikel = tb_pemberitahuan::select('tb_pemberitahuan.*', 'tb_pemberitahuan_category.pemberitahuan_category_name')
            ->join('tb_pemberitahuan_category', 'tb_pemberitahuan.category', '=', 'tb_pemberitahuan_category.id_pemberitahuan_category')
            ->where('tb_pemberitahuan.type', 1)
            ->findOrFail($id_artikel);

        return view('admin.artikel.show', [
            'menu_active' => 'informasi',
            'info_active' => 'artikel',
            'profile_active' => 'artikel',
            'token' => $token,
            'artikel' => $artikel,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_artikel = $request->route('artikel');
        $token = $request->session()->get('token') ?? $request->input('token');
        $artikel = tb_pemberitahuan::where(['type' => 1])->findOrFail($id_artikel);
        $categories = tb_pemberitahuan_category::where('type', 1)->get();

        return view('admin.artikel.edit', [
            'menu_active' => 'informasi',
            'info_active' => 'artikel',
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
        $id_artikel = $request->route('artikel');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'nama' => 'required',
            'level' => 'required',
            'id_pemberitahuan_category' => 'required',
            'text' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama artikel harus diisi.',
            'level.required' => 'Kolom level artikel harus diisi.',
            'id_pemberitahuan_category.required' => 'Kolom kategori artikel harus diisi.',
            'text.required' => 'Kolom isi artikel harus diisi.',
            'thumbnail' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        $data = tb_pemberitahuan::where('tb_pemberitahuan.type', 1)
            ->findOrFail($id_artikel);

        if ($request->hasFile('thumbnail')) {
            // Hapus gambar sebelumnya jika ada
            if (! empty($data->thumbnail)) {
                $oldImagePath = public_path('img/artikel/'.$data->thumbnail);
                if (file_exists($oldImagePath) && ! is_dir($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('thumbnail')->hashName();
            $request->file('thumbnail')->move('img/artikel', $imageName);
            $data->thumbnail = $imageName;
        }

        $data->update([
            'nama' => $request->nama,
            'level' => $request->level,
            'category' => $request->id_pemberitahuan_category,
            'text' => $request->text,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('artikel.index', ['token' => $token])->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_artikel = $request->route('artikel');
        $token = $request->session()->get('token') ?? $request->input('token');

        $artikel = tb_pemberitahuan::where('id_pemberitahuan', $id_artikel)
            ->where('type', 4)
            ->firstOrFail();

        $imagePath = public_path('img/artikel/'.$artikel->thumbnail);

        $artikel->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('artikel.index', ['token' => $request->token])->with('success', 'Artikel berhasil dihapus');
    }
}
