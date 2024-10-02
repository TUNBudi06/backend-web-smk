<?php

namespace App\Http\Controllers;

use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $news = tb_pemberitahuan::where(['type' => 3])
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.berita.index', [
            'menu_active' => 'informasi',
            'info_active' => 'berita',
            'token' => $token,
            'news' => $news,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.berita.create', [
            'menu_active' => 'informasi',
            'info_active' => 'berita',
            'news' => tb_pemberitahuan_category::where(['type' => 3])->get(),
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
            'location' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama berita harus diisi.',
            'level.required' => 'Kolom level berita harus diisi.',
            'id_pemberitahuan_category.required' => 'Kolom kategori berita harus diisi.',
            'text.required' => 'Kolom isi berita harus diisi.',
            'location.required' => 'Kolom lokasi berita harus diisi.',
            'thumbnail.required' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        // Simpan data ke tabel news
        $data = new tb_pemberitahuan;
        $data->nama = $request->nama;
        $data->level = $request->level;
        $data->category = $request->id_pemberitahuan_category;
        $data->text = $request->text;
        $data->location = $request->location;
        $data->approved = $request->session()->get('user')->role == 1 ? 1 : 0;
        $data->published_by = $request->session()->get('user')->name;
        $data->jurnal_by = $request->jurnal_by ?? '-';
        $data->type = 3;
        $data->viewer = 0;

        // Simpan gambar
        if ($request->hasFile('thumbnail')) {
            $fileContents = file_get_contents($request->file('thumbnail')->getRealPath());
            $imageName = hash('sha256', $fileContents).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move('img/berita', $imageName);
            $data->thumbnail = $imageName;
        } else {
            $data->thumbnail = 'img/no_image.png';
        }

        $data->save();

        return redirect()->route('berita.index', ['token' => $token])->with('success', 'Berita baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_news = $request->route('berita');
        $token = $request->session()->get('token') ?? $request->input('token');
        $news = tb_pemberitahuan::select('tb_pemberitahuan.*', 'tb_pemberitahuan_category.pemberitahuan_category_name')
            ->join('tb_pemberitahuan_category', 'tb_pemberitahuan.category', '=', 'tb_pemberitahuan_category.id_pemberitahuan_category')
            ->where(['tb_pemberitahuan.type' => 3])
            ->findOrFail($id_news);

        return view('admin.berita.show', [
            'menu_active' => 'informasi',
            'info_active' => 'berita',
            'profile_active' => 'berita',
            'token' => $token,
            'news' => $news,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_news = $request->route('berita');
        $token = $request->session()->get('token') ?? $request->input('token');
        $news = tb_pemberitahuan::where(['type' => 3])->findOrFail($id_news);
        $categories = tb_pemberitahuan_category::where(['type' => 3])->get();

        return view('admin.berita.edit', [
            'menu_active' => 'informasi',
            'info_active' => 'berita',
            'token' => $token,
            'news' => $news,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_news = $request->route('berita');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'nama' => 'required',
            'level' => 'required',
            'id_pemberitahuan_category' => 'required',
            'text' => 'required',
            'location' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama berita harus diisi.',
            'level.required' => 'Kolom level berita harus diisi.',
            'id_pemberitahuan_category.required' => 'Kolom kategori berita harus diisi.',
            'text.required' => 'Kolom isi berita harus diisi.',
            'location.required' => 'Kolom lokasi berita harus diisi.',
            'thumbnail' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        // Temukan data berita
        $data = tb_pemberitahuan::where('tb_pemberitahuan.type', 3)
            ->findOrFail($id_news);

        // Periksa apakah ada pergantian gambar
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar sebelumnya jika ada
            if (! empty($data->thumbnail)) {
                $oldImagePath = public_path('img/berita/'.$data->thumbnail);
                if (file_exists($oldImagePath) && ! is_dir($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('thumbnail')->hashName();
            $request->file('thumbnail')->move('img/berita', $imageName);
            $data->thumbnail = $imageName;
        }

        // Update data berita
        $data->update([
            'nama' => $request->nama,
            'level' => $request->level,
            'category' => $request->id_pemberitahuan_category,
            'text' => $request->text,
            'location' => $request->location,
            'viewer' => $request->viewer,
            'jurnal_by' => $request->jurnal_by,
        ]);

        return redirect()->route('berita.index', ['token' => $token])->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_news = $request->route('berita');
        $token = $request->session()->get('token') ?? $request->input('token');

        $news = tb_pemberitahuan::where('id_pemberitahuan', $id_news)
            ->where('type', 3)
            ->firstOrFail();

        $imagePath = public_path('img/berita/'.$news->thumbnail);

        $news->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('berita.index', ['token' => $request->token])->with('success', 'Berita berhasil dihapus.');
    }
}
