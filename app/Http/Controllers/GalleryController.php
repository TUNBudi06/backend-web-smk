<?php

namespace App\Http\Controllers;

use App\Models\tb_category_gallery;
use App\Models\tb_gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $gallery = tb_gallery::orderBy('gallery_timestamp', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.gallery.index', [
            'menu_active' => 'gallery',
            'token' => $token,
            'gallery' => $gallery,
            'category_gallery' => tb_category_gallery::all(),
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
        $data = new tb_gallery();
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_gallery = $request->route("gallery");
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_gallery = $request->route("gallery");
        $token = $request->session()->get('token') ?? $request->input('token');

        $gallery = tb_gallery::findOrFail($id_gallery);
        $gallery->delete();

        return redirect()->route('gallery.index', ['token' => $request->token])->with('success', 'Data deleted successfully.');
    }
}
