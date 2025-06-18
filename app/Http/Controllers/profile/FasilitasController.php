<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_facilities;
use App\Models\tb_prodi;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show') ?? 10;
        $fasilitas = tb_facilities::orderBy('id_facility', 'desc')->paginate($perPage);
        $count = tb_facilities::count();

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.fasilitas.index', [
            'menu_active' => 'profile',
            'profile_active' => 'fasilitas',
            'token' => $token,
            'fasilitas' => $fasilitas,
            'count' => $count,
            'prodis' => tb_prodi::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.fasilitas.create', [
            'menu_active' => 'profile',
            'profile_active' => 'fasilitas',
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
            'facility_name' => 'required',
            'id_prodi' => 'required',
            'facility_text' => 'required',
            'facility_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'facility_name.required' => 'Kolom nama fasilitas harus diisi.',
            'id_category.required' => 'Kolom kategori fasilitas harus diisi.',
            'facility_text.required' => 'Kolom isi fasilitas harus diisi.',
            'facility_image' => 'Kolom gambar wajib diisi',
            'facility_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Simpan data ke tabel facility
        $data = new tb_facilities;
        $data->facility_name = $request->facility_name;
        $data->id_prodi = $request->id_prodi;
        $data->facility_text = $request->facility_text;

        // Simpan gambar
        if ($request->hasFile('facility_image')) {
            $fileContents = file_get_contents($request->file('facility_image')->getRealPath());
            $imageName = hash('sha256', $fileContents).'.'.$request->file('facility_image')->getClientOriginalExtension();
            $request->file('facility_image')->move('img/fasilitas/', $imageName);
            $data->facility_image = $imageName;
        }

        $data->save();

        return redirect()->route('fasilitas.index', ['token' => $token])->with('success', 'Fasilitas baru berhasil ditambahkan.');
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
        $id_facility = $request->route('fasilitas');
        $token = $request->session()->get('token') ?? $request->input('token');
        $fasilitas = tb_facilities::findOrFail($id_facility);
        $prodis = tb_prodi::all();

        return view('admin.page.profile.fasilitas.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'fasilitas',
            'token' => $token,
            'fasilitas' => $fasilitas,
            'prodis' => $prodis,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_facility = $request->route('fasilitas');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'facility_name' => 'required',
            'id_prodi' => 'required',
            'facility_text' => 'required',
            'facility_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'facility_name.required' => 'Kolom nama fasilitas harus diisi.',
            'id_category.required' => 'Kolom kategori fasilitas harus diisi.',
            'facility_text.required' => 'Kolom isi fasilitas harus diisi.',
            'facility_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Temukan data fasilitas
        $data = tb_facilities::findOrFail($id_facility);

        // Periksa apakah ada pergantian gambar
        if ($request->hasFile('facility_image')) {
            // Hapus gambar sebelumnya jika ada
            if ($data->facility_image !== null) {
                $oldImagePath = public_path('img/fasilitas/'.$data->facility_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('facility_image')->hashName();
            $request->file('facility_image')->move('img/fasilitas/', $imageName);
            $data->facility_image = $imageName;
        }

        // Update data fasilitas
        $data->update([
            'facility_name' => $request->facility_name,
            'id_prodi' => $request->id_prodi,
            'facility_text' => $request->facility_text,
        ]);

        return redirect()->route('fasilitas.index', ['token' => $token])->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_facility = $request->route('fasilitas');
        $token = $request->session()->get('token') ?? $request->input('token');

        $facility = tb_facilities::findOrFail($id_facility);
        $imagePath = public_path('img/fasilitas/'.$facility->facility_image);

        $facility->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('fasilitas.index', ['token' => $request->token])->with('success', 'Fasilitas berhasil dihapus.');
    }
}
