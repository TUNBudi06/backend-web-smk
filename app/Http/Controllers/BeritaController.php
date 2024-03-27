<?php

namespace App\Http\Controllers;

use App\Models\tb_category_news;
use App\Models\tb_news;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
            'news_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'news_image.max' => 'The image may not be greater than 10MB.',
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
            $imageName = Str::random(20) . '.' . $request->file('news_image')->getClientOriginalExtension();
            $request->file('news_image')->move('img/berita', $imageName);
            $data->news_image = $imageName;
        }

        $data->save();

        return redirect()->route('berita.index', ['token' => $token])->with('success', 'Data added successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
