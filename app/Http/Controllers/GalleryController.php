<?php

namespace App\Http\Controllers;

use App\Models\tb_category_gallery;
use App\Models\tb_gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $page = $request->input('page', 1);

        $gallery = Cache::flexible("gallery_{$page}_show_{$perPage}", [3, 20], function () use ($perPage) {
            return tb_gallery::orderBy('id_gallery', 'desc')->paginate($perPage);
        });
        $count = Cache::flexible("gallery_count", [3, 20], fn () => tb_gallery::count());

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.gallery.index', [
            'menu_active' => 'gallery',
            'token' => $token,
            'gallery' => $gallery,
            'category_gallery' => tb_category_gallery::all(),
            'count' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.gallery.create', [
            'menu_active' => 'gallery',
            'gallery' => tb_category_gallery::all(),
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
            'gallery_title' => 'required',
            'id_category' => 'required',
            'gallery_text' => 'required',
            'gallery_location' => 'required',
            'gallery_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'gallery_file.max' => 'The image may not be greater than 10MB.',
        ]);

        // Simpan data ke tabel gallery
        $data = new tb_gallery;
        $data->gallery_title = $request->gallery_title;
        $data->id_category = $request->id_category;
        $data->gallery_text = $request->gallery_text;
        $data->gallery_location = $request->gallery_location;

        if ($request->hasFile('gallery_file')) {
            $file = $request->file('gallery_file');
            $fileMimeType = $file->getClientMimeType();
            $imageName = data_manager::renameFile($file);
            $file->move('img/gallery', $imageName);

            // Simpan nama file dan tipe file ke dalam database
            $data->gallery_file = $imageName;
            $data->file_type = $fileMimeType;
        }

        $data->save();

        return redirect()->route('gallery.index', ['token' => $token])->with('success', 'Data added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_gallery = $request->route('gallery');
        $token = $request->session()->get('token') ?? $request->input('token');
        $gallery = tb_gallery::findOrFail($id_gallery);
        $categories = tb_category_gallery::all();

        return view('admin.gallery.show', [
            'menu_active' => 'gallery',
            'profile_active' => 'gallery',
            'token' => $token,
            'gallery' => $gallery,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_gallery = $request->route('gallery');
        $token = $request->session()->get('token') ?? $request->input('token');
        $gallery = tb_gallery::findOrFail($id_gallery);
        $categories = tb_category_gallery::all();

        return view('admin.gallery.edit', [
            'menu_active' => 'gallery',
            'token' => $token,
            'gallery' => $gallery,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $id_gallery = $request->route('gallery');
        $request->validate([
            'gallery_title' => 'required',
            'id_category' => 'required',
            'gallery_text' => 'required',
            'gallery_location' => 'required',
            'gallery_file' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'gallery_file.max' => 'The image may not be greater than 10MB.',
        ]);

        // Temukan data galeri yang akan disunting
        $data = tb_gallery::findOrFail($id_gallery);
        $data->gallery_title = $request->gallery_title;
        $data->id_category = $request->id_category;
        $data->gallery_text = $request->gallery_text;
        $data->gallery_location = $request->gallery_location;

        if ($request->hasFile('gallery_file')) {
            $file = $request->file('gallery_file');
            $fileMimeType = $file->getClientMimeType();
            $imageName = data_manager::renameFile($file);
            $file->move('img/gallery', $imageName);

            // Hapus file lama jika ada dan simpan file baru
            if ($data->gallery_file) {
                // Hapus file lama
                Storage::delete('img/gallery/'.$data->gallery_file);
            }

            // Simpan nama file dan tipe file ke dalam database
            $data->gallery_file = $imageName;
            $data->file_type = $fileMimeType;
        }

        $data->save();

        return redirect()->route('gallery.index', ['token' => $token])->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_gallery = $request->route('gallery');
        $token = $request->session()->get('token') ?? $request->input('token');

        $gallery = tb_gallery::findOrFail($id_gallery);
        $imagePath = public_path('img/gallery/'.$gallery->gallery_file);

        $gallery->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('gallery.index', ['token' => $request->token])->with('success', 'Data deleted successfully.');
    }
}
