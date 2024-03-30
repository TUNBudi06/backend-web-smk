<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_jurusan;
use App\Models\tb_prodi;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $jurusan = tb_jurusan::orderBy('id_jurusan', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.page.profile.jurusan.index', [
            'menu_active' => 'profile',
            'profile_active' => 'jurusan',
            'token' => $token,
            'jurusan' => $jurusan,
            'prodis' => tb_prodi::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.jurusan.create', [
            'menu_active' => 'profile',
            'profile_active' => 'jurusan',
            'prodi' => tb_prodi::all(),
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
            'jurusan_nama' => 'required',
            'jurusan_short' => 'required',
            'id_prodi' => 'required',
            'jurusan_text' => 'required',
            'jurusan_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'jurusan_thumbnail.max' => 'The image may not be greater than 10MB.',
        ]);

        // Simpan data ke tabel news
        $data = new tb_jurusan();
        $data->jurusan_nama = $request->jurusan_nama;
        $data->jurusan_short = $request->jurusan_short;
        $data->id_prodi = $request->id_prodi;
        $data->jurusan_text = $request->jurusan_text;

        // Simpan gambar
        if ($request->hasFile('jurusan_thumbnail')) {
            $fileContents = file_get_contents($request->file('jurusan_thumbnail')->getRealPath());
            $imageName = hash('sha256', $fileContents) . '.' . $request->file('jurusan_thumbnail')->getClientOriginalExtension();
            $request->file('jurusan_thumbnail')->move('img/jurusan/thumbnail', $imageName);
            $data->jurusan_thumbnail = $imageName;
        }

        $data->save();

        return redirect()->route('jurusan.index', ['token' => $token])->with('success', 'Data added successfully.');
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
        $id_jurusan = $request->route("jurusan");
        $token = $request->session()->get('token') ?? $request->input('token');
        $jurusan = tb_jurusan::findOrFail($id_jurusan);
        $prodis = tb_prodi::all();

        return view('admin.page.profile.jurusan.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'jurusan',
            'token' => $token,
            'jurusan' => $jurusan,
            'prodis' => $prodis,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_news = $request->route("jurusan");
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'jurusan_nama' => 'required',
            'jurusan_short' => 'required',
            'id_prodi' => 'required',
            'jurusan_text' => 'required',
            'jurusan_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'jurusan_thumbnail.max' => 'The image may not be greater than 10MB.',
        ]);

        // Temukan data jurusan
        $data = tb_jurusan::findOrFail($id_news);

        // Periksa apakah ada pergantian gambar
        if ($request->hasFile('jurusan_thumbnail')) {
            // Hapus gambar sebelumnya jika ada
            if ($data->jurusan_thumbnail !== null) {
                $oldImagePath = public_path('img/jurusan/thumbnail' . $data->jurusan_thumbnail);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('jurusan_thumbnail')->hashName();
            $request->file('jurusan_thumbnail')->move('img/jurusan/thumbnail', $imageName);
            $data->jurusan_thumbnail = $imageName;
        }

        // Update data jurusan
        $data->update([
            'jurusan_nama' => $request->jurusan_nama,
            'jurusan_short' => $request->jurusan_short,
            'id_prodi' => $request->id_prodi,
            'jurusan_text' => $request->jurusan_text,
        ]);

        return redirect()->route('jurusan.index', ['token' => $token])->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_jurusan = $request->route("jurusan");
        $token = $request->session()->get('token') ?? $request->input('token');

        $jurusan = tb_jurusan::findOrFail($id_jurusan);
        $jurusan->delete();

        return redirect()->route('jurusan.index', ['token' => $request->token])->with('success', 'Data deleted successfully.');
    }
}
