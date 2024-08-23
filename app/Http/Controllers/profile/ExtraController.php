<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_extra;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $extra = tb_extra::orderBy('id_extra', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.extra.index', [
            'menu_active' => 'academic',
            'profile_active' => 'extra',
            'token' => $token,
            'extra' => $extra,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.extra.create', [
            'menu_active' => 'academic',
            'profile_active' => 'extra',
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
            'extra_name' => 'required',
            'extra_text' => 'required',
            'extra_type' => 'required',
            'extra_hari' => 'required',
            'instagram' => 'required',
            'telegram' => 'required',
            'extra_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'extra_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'extra_name.required' => 'Kolom nama extrakurikuler harus diisi.',
            'extra_text.required' => 'Kolom isi extrakurikuler harus diisi.',
            'extra_type.required' => 'Kolom type extrakurikuler harus diisi.',
            'extra_hari.required' => 'Kolom jadwal extrakurikuler harus diisi.',
            'instagram.required' => 'Kolom instagram extrakurikuler harus diisi.',
            'telegram.required' => 'Kolom telegram extrakurikuler harus diisi.',
            'extra_image.required' => 'Kolom gambar wajib diisi',
            'extra_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'extra_logo.required' => 'Kolom gambar wajib diisi',
            'extra_logo.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Simpan data ke tabel tb_extra
        $data = new tb_extra;
        $data->extra_name = $request->extra_name;
        $data->extra_text = $request->extra_text;
        $data->extra_type = $request->extra_type;
        $data->extra_hari = $request->extra_hari;
        $data->instagram = $request->instagram;
        $data->telegram = $request->telegram;

        if ($request->hasFile('extra_image')) {
            $fileContents = file_get_contents($request->file('extra_image')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('extra_image')->getClientOriginalExtension();
            $request->file('extra_image')->move(public_path('img/extrakurikuler/cover/'), $imageName);
            $data->extra_image = $imageName;
        }

        if ($request->hasFile('extra_logo')) {
            $fileContents = file_get_contents($request->file('extra_logo')->getRealPath());
            $logoName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('extra_logo')->getClientOriginalExtension();
            $request->file('extra_logo')->move(public_path('img/extrakurikuler/logo/'), $logoName);
            $data->extra_logo = $logoName;
        }

        $data->save();

        return redirect()->route('extra.index', ['token' => $token])->with('success', 'Extrakurikuler baru berhasil ditambahkan.');
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
        $id_extra = $request->route('extra');
        $token = $request->session()->get('token') ?? $request->input('token');
        $extra = tb_extra::findOrFail($id_extra);

        return view('admin.page.profile.extra.edit', [
            'menu_active' => 'academic',
            'profile_active' => 'extra',
            'token' => $token,
            'extra' => $extra,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_extra = $request->route('extra');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'extra_name' => 'required',
            'extra_text' => 'required',
            'extra_type' => 'required',
            'extra_hari' => 'required',
            'instagram' => 'required',
            'telegram' => 'required',
            'extra_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'extra_logo' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'extra_name.required' => 'Kolom nama extrakurikuler harus diisi.',
            'extra_text.required' => 'Kolom isi extrakurikuler harus diisi.',
            'extra_type.required' => 'Kolom type extrakurikuler harus diisi.',
            'extra_hari.required' => 'Kolom jadwal extrakurikuler harus diisi.',
            'instagram.required' => 'Kolom instagram extrakurikuler harus diisi.',
            'telegram.required' => 'Kolom telegram extrakurikuler harus diisi.',
            'extra_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'extra_logo.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Cari data extrakurikuler berdasarkan ID
        $data = tb_extra::findOrFail($id_extra);
        $data->extra_name = $request->extra_name;
        $data->extra_text = $request->extra_text;
        $data->extra_type = $request->extra_type;
        $data->extra_hari = $request->extra_hari;
        $data->instagram = $request->instagram;
        $data->telegram = $request->telegram;

        if ($request->hasFile('extra_image')) {
            // Hapus gambar lama jika ada
            if ($data->extra_image && file_exists(public_path('img/extrakurikuler/cover/'.$data->extra_image))) {
                unlink(public_path('img/extrakurikuler/cover/'.$data->extra_image));
            }

            $fileContents = file_get_contents($request->file('extra_image')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('extra_image')->getClientOriginalExtension();
            $request->file('extra_image')->move(public_path('img/extrakurikuler/cover/'), $imageName);
            $data->extra_image = $imageName;
        }

        if ($request->hasFile('extra_logo')) {
            // Hapus logo lama jika ada
            if ($data->extra_logo && file_exists(public_path('img/extrakurikuler/logo/'.$data->extra_logo))) {
                unlink(public_path('img/extrakurikuler/logo/'.$data->extra_logo));
            }

            $fileContents = file_get_contents($request->file('extra_logo')->getRealPath());
            $logoName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('extra_logo')->getClientOriginalExtension();
            $request->file('extra_logo')->move(public_path('img/extrakurikuler/logo/'), $logoName);
            $data->extra_logo = $logoName;
        }

        $data->save();

        return redirect()->route('extra.index', ['token' => $token])->with('success', 'Extrakurikuler berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_extra = $request->route('extra');
        $token = $request->session()->get('token') ?? $request->input('token');

        $extra = tb_extra::findOrFail($id_extra);
        $extra->delete();

        return redirect()->route('extra.index', ['token' => $request->token])->with('success', 'Extrakurikuler berhasil dihapus.');
    }
}
