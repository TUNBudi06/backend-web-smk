<?php

namespace App\Http\Controllers\mitra;

use App\Http\Controllers\Controller;
use App\Models\tb_kemitraan;
use Illuminate\Http\Request;

class KemitraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $kemitraan = tb_kemitraan::orderBy('id_kemitraan', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.kemitraan.index', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'kemitraan',
            'token' => $token,
            'kemitraan' => $kemitraan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.kemitraan.create', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'kemitraan',
            'token' => $token,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Mengambil token dari session atau input
        $token = $request->session()->get('token') ?? $request->input('token');

        // Validasi input
        $request->validate([
            'kemitraan_name' => 'required',
            'kemitraan_description' => 'required',
            'kemitraan_city' => 'required',
            'kemitraan_location_detail' => 'required',
            'kemitraan_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'kemitraan_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'kemitraan_name.required' => 'Kolom nama kemitraan harus diisi.',
            'kemitraan_description.required' => 'Kolom isi kemitraan harus diisi.',
            'kemitraan_city.required' => 'Kolom daerah kemitraan harus diisi.',
            'kemitraan_location_detail.required' => 'Kolom detail lokasi kemitraan harus diisi.',
            'kemitraan_thumbnail.required' => 'Kolom gambar wajib diisi',
            'kemitraan_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'kemitraan_logo.required' => 'Kolom gambar wajib diisi',
            'kemitraan_logo.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Simpan data ke tabel tb_kemitraan
        $data = new tb_kemitraan;
        $data->kemitraan_name = $request->kemitraan_name;
        $data->kemitraan_description = $request->kemitraan_description;
        $data->kemitraan_city = $request->kemitraan_city;
        $data->kemitraan_location_detail = $request->kemitraan_location_detail;

        if ($request->hasFile('kemitraan_thumbnail')) {
            $fileContents = file_get_contents($request->file('kemitraan_thumbnail')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('kemitraan_thumbnail')->getClientOriginalExtension();
            $request->file('kemitraan_thumbnail')->move(public_path('img/kemitraan/cover/'), $imageName);
            $data->kemitraan_thumbnail = $imageName;
        }

        if ($request->hasFile('kemitraan_logo')) {
            $fileContents = file_get_contents($request->file('kemitraan_logo')->getRealPath());
            $logoName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('kemitraan_logo')->getClientOriginalExtension();
            $request->file('kemitraan_logo')->move(public_path('img/kemitraan/logo/'), $logoName);
            $data->kemitraan_logo = $logoName;
        }

        $data->save();

        return redirect()->route('kemitraan.index', ['token' => $token])->with('success', 'Kemitraan baru berhasil ditambahkan.');
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
        $id_kemitraan = $request->route('kemitraan');
        $token = $request->session()->get('token') ?? $request->input('token');
        $kemitraan = tb_kemitraan::findOrFail($id_kemitraan);

        return view('admin.kemitraan.edit', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'kemitraan',
            'token' => $token,
            'kemitraan' => $kemitraan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_kemitraan = $request->route('kemitraan');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'kemitraan_name' => 'required',
            'kemitraan_description' => 'required',
            'kemitraan_city' => 'required',
            'kemitraan_location_detail' => 'required',
            'kemitraan_thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'kemitraan_logo' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'kemitraan_name.required' => 'Kolom nama kemitraan harus diisi.',
            'kemitraan_description.required' => 'Kolom isi kemitraan harus diisi.',
            'kemitraan_city.required' => 'Kolom daerah kemitraan harus diisi.',
            'kemitraan_location_detail.required' => 'Kolom detail lokasi kemitraan harus diisi.',
            'kemitraan_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'kemitraan_logo.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Cari data kemitraan berdasarkan ID
        $data = tb_kemitraan::findOrFail($id_kemitraan);
        $data->kemitraan_name = $request->kemitraan_name;
        $data->kemitraan_description = $request->kemitraan_description;
        $data->kemitraan_city = $request->kemitraan_city;
        $data->kemitraan_location_detail = $request->kemitraan_location_detail;

        if ($request->hasFile('kemitraan_thumbnail')) {
            // Hapus gambar lama jika ada
            if ($data->kemitraan_thumbnail && file_exists(public_path('img/kemitraan/cover/'.$data->kemitraan_thumbnail))) {
                unlink(public_path('img/kemitraan/cover/'.$data->kemitraan_thumbnail));
            }

            $fileContents = file_get_contents($request->file('kemitraan_thumbnail')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('kemitraan_thumbnail')->getClientOriginalExtension();
            $request->file('kemitraan_thumbnail')->move(public_path('img/kemitraan/cover/'), $imageName);
            $data->kemitraan_thumbnail = $imageName;
        }

        if ($request->hasFile('kemitraan_logo')) {
            // Hapus logo lama jika ada
            if ($data->kemitraan_logo && file_exists(public_path('img/kemitraan/logo/'.$data->kemitraan_logo))) {
                unlink(public_path('img/kemitraan/logo/'.$data->kemitraan_logo));
            }

            $fileContents = file_get_contents($request->file('kemitraan_logo')->getRealPath());
            $logoName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('kemitraan_logo')->getClientOriginalExtension();
            $request->file('kemitraan_logo')->move(public_path('img/kemitraan/logo/'), $logoName);
            $data->kemitraan_logo = $logoName;
        }

        $data->save();

        return redirect()->route('kemitraan.index', ['token' => $token])->with('success', 'Kemitraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_kemitraan = $request->route('kemitraan');
        $token = $request->session()->get('token') ?? $request->input('token');

        $kemitraan = tb_kemitraan::findOrFail($id_kemitraan);

        if ($kemitraan->kemitraan_logo && file_exists(public_path('img/kemitraan/logo/'.$kemitraan->kemitraan_logo))) {
            unlink(public_path('img/kemitraan/logo/'.$kemitraan->kemitraan_logo));
        }
        $kemitraan->delete();

        return redirect()->route('kemitraan.index', ['token' => $request->token])->with('success', 'Kemitraan berhasil dihapus.');
    }
}
