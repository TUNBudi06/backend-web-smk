<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JurusanResource;
use App\Models\tb_jurusan;
use App\Models\tb_prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = tb_jurusan::with('prodis')->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => JurusanResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prodi = tb_prodi::where('prodi_name', $request->input('id_prodi'))->first();

        $validator = Validator::make($request->all(), [
            'jurusan_nama' => 'required',
            'jurusan_short' => 'required',
            'id_prodi' => 'required',
            'jurusan_text' => 'required',
            'jurusan_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'jurusan_nama.required' => 'Kolom nama jurusan harus diisi.',
            'jurusan_short.required' => 'Kolom inisial jurusan harus diisi.',
            'id_prodi.required' => 'Kolom kategori jurusan harus diisi.',
            'jurusan_text.required' => 'Kolom isi jurusan harus diisi.',
            'jurusan_thumbnail' => 'Kolom gambar wajib diisi',
            'jurusan_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Simpan data ke tabel facility
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

        // Berikan respons berhasil dengan data fasilitas yang baru saja dibuat
        return response()->json([
            'message' => 'Fasilitas baru berhasil ditambahkan.',
            'data' => new JurusanResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jurusan = tb_jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $jurusan,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Temukan data jurusan berdasarkan ID
        $data = tb_jurusan::find($id);

        // Jika data tidak ditemukan, kembalikan pesan kesalahan
        if (!$data) {
            return response()->json(['errors' => 'Data jurusan tidak ditemukan'], 404);
        }

        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'jurusan_nama' => 'required',
            'jurusan_short' => 'required',
            'id_prodi' => 'required',
            'jurusan_text' => 'required',
            'jurusan_thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'jurusan_nama.required' => 'Kolom nama jurusan harus diisi.',
            'jurusan_short.required' => 'Kolom inisial jurusan harus diisi.',
            'id_prodi.required' => 'Kolom kategori jurusan harus diisi.',
            'jurusan_text.required' => 'Kolom isi jurusan harus diisi.',
            'jurusan_thumbnail.image' => 'File harus berupa gambar.',
            'jurusan_thumbnail.mimes' => 'Format gambar yang diperbolehkan adalah jpeg, png, jpg, atau gif.',
            'jurusan_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Perbarui data jurusan dengan data yang baru
        $data->jurusan_nama = $request->input('jurusan_nama');
        $data->jurusan_short = $request->input('jurusan_short');
        $data->id_prodi = $request->input('id_prodi');
        $data->jurusan_text = $request->input('jurusan_text');

        // Jika ada file gambar yang diunggah, simpan gambar baru
        if ($request->hasFile('jurusan_thumbnail')) {
            $image = $request->file('jurusan_thumbnail');
            $imageName = $image->hashName();
            $image->move('img/jurusan/thumbnail', $imageName);
            $data->jurusan_thumbnail = $imageName;
        }

        // Simpan perubahan
        $data->save();

        // Berikan respons berhasil dengan data jurusan yang baru saja diperbarui
        return response()->json([
            'message' => 'Data jurusan berhasil diperbarui.',
            'data' => new JurusanResource($data),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jurusan = tb_jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $jurusan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
