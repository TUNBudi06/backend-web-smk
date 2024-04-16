<?php

namespace App\Http\Controllers;

use App\Models\tb_category_news;
use App\Models\tb_news;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $news = tb_news::orderBy('news_timestamp', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.berita.index', [
            'menu_active' => 'berita',
            'token' => $token,
            'news' => $news,
            'category_news' => tb_category_news::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.berita.create', [
            'menu_active' => 'berita',
            'news' => tb_category_news::all(),
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
            'news_title' => 'required',
            'news_level' => 'required',
            'id_category' => 'required',
            'news_content' => 'required',
            'news_location' => 'required',
            'news_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ], [
            'news_title.required' => 'Kolom nama berita harus diisi.',
            'news_level.required' => 'Kolom level berita harus diisi.',
            'id_category.required' => 'Kolom kategori berita harus diisi.',
            'news_content.required' => 'Kolom isi berita harus diisi.',
            'news_location.required' => 'Kolom lokasi berita harus diisi.',
            'news_image' => 'Kolom gambar wajib diisi',
            'news_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB'
        ]);

        // Simpan data ke tabel news
        $data = new tb_news();
        $data->news_title = $request->news_title;
        $data->news_level = $request->news_level;
        $data->id_category = $request->id_category;
        $data->news_content = $request->news_content;
        $data->news_location = $request->news_location;
        $data->news_viewer = $request->news_viewer;

        // Simpan gambar
        if ($request->hasFile('news_image')) {
            $fileContents = file_get_contents($request->file('news_image')->getRealPath());
            $imageName = hash('sha256', $fileContents) . '.' . $request->file('news_image')->getClientOriginalExtension();
            $request->file('news_image')->move('img/berita', $imageName);
            $data->news_image = $imageName;
        }

        $data->save();

        return redirect()->route('berita.index', ['token' => $token])->with('success', 'Berita baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_news = $request->route("berita");
        $token = $request->session()->get('token') ?? $request->input('token');
        $news = tb_news::findOrFail($id_news);
        $categories = tb_category_news::all();

        return view('admin.berita.show', [
            'menu_active' => 'berita',
            'profile_active' => 'berita',
            'token' => $token,
            'news' => $news,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_news = $request->route("berita");
        $token = $request->session()->get('token') ?? $request->input('token');
        $news = tb_news::findOrFail($id_news);
        $categories = tb_category_news::all();

        return view('admin.berita.edit', [
            'menu_active' => 'berita',
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
        $id_news = $request->route("berita");
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'news_title' => 'required',
            'news_level' => 'required',
            'id_category' => 'required',
            'news_content' => 'required',
            'news_location' => 'required',
            'news_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ], [
            'news_title.required' => 'Kolom nama berita harus diisi.',
            'news_level.required' => 'Kolom level berita harus diisi.',
            'id_category.required' => 'Kolom kategori berita harus diisi.',
            'news_content.required' => 'Kolom isi berita harus diisi.',
            'news_location.required' => 'Kolom lokasi berita harus diisi.',
            'news_image' => 'Kolom gambar wajib diisi',
            'news_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB'
        ]);

        // Temukan data berita
        $data = tb_news::findOrFail($id_news);

        // Periksa apakah ada pergantian gambar
        if ($request->hasFile('news_image')) {
            // Hapus gambar sebelumnya jika ada
            if ($data->news_image !== null) {
                $oldImagePath = public_path('img/berita/' . $data->news_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('news_image')->hashName();
            $request->file('news_image')->move('img/berita', $imageName);
            $data->news_image = $imageName;
        }

        // Update data berita
        $data->update([
            'news_title' => $request->news_title,
            'news_level' => $request->news_level,
            'id_category' => $request->id_category,
            'news_content' => $request->news_content,
            'news_location' => $request->news_location,
            'news_viewer' => $request->news_viewer,
        ]);

        return redirect()->route('berita.index', ['token' => $token])->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_news = $request->route("berita");
        $token = $request->session()->get('token') ?? $request->input('token');

        $news = tb_news::findOrFail($id_news);
        $news->delete();

        return redirect()->route('berita.index', ['token' => $request->token])->with('success', 'Berita berhasil dihapus.');
    }
}
