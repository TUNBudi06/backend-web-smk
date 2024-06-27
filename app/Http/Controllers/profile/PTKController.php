<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_ptk;
use Illuminate\Http\Request;

class PTKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $ptk = tb_ptk::orderBy('id', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.ptk.index', [
            'menu_active' => 'profile',
            'profile_active' => 'ptk',
            'token' => $token,
            'ptk' => $ptk,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.ptk.create', [
            'menu_active' => 'ptk',
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
            'nip' => 'required',
            'nuptk' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'mata_pelajaran' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ], [
            'nip.required' => 'Kolom NIP harus diisi.',
            'nuptk.required' => 'Kolom NUPTK harus diisi.',
            'nama.required' => 'Kolom isi PTK harus diisi.',
            'tanggal_lahir.required' => 'Kolom tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Kolom tanggal lahir harus dalam format tanggal yang benar.',
            'tempat_lahir.required' => 'Kolom tempat lahir harus diisi.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin harus diisi.',
            'mata_pelajaran.required' => 'Kolom mata pelajaran harus diisi.',
            'foto.required' => 'Kolom foto wajib diisi',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 10MB'
        ]);

        $data = new tb_ptk();
        $data->nip = $request->nip;
        $data->nuptk = $request->nuptk;
        $data->nama = $request->nama;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->alamat = $request->alamat;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->mata_pelajaran = $request->mata_pelajaran;

        // Simpan gambar
        if ($request->hasFile('foto')) {
            $fileContents = file_get_contents($request->file('foto')->getRealPath());
            $imageName = hash('sha256', $fileContents) . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move('img/guru', $imageName);
            $data->foto = $imageName;
        }

        $data->save();

        return redirect()->route('ptk.index', ['token' => $token])->with('success', 'PTK baru berhasil ditambahkan.');
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
        $id = $request->route("ptk");
        $token = $request->session()->get('token') ?? $request->input('token');
        $ptk = tb_ptk::findOrFail($id);

        return view('admin.page.profile.ptk.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'ptk',
            'token' => $token,
            'ptk' => $ptk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_ptk = $request->route("ptk");
        $request->validate([
            'nip' => 'sometimes',
            'nuptk' => 'sometimes',
            'nama' => 'sometimes',
            'tanggal_lahir' => 'sometimes|date',
            'tempat_lahir' => 'sometimes',
            'jenis_kelamin' => 'sometimes',
            'mata_pelajaran' => 'sometimes',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ], [
            'tanggal_lahir.date' => 'Kolom tanggal lahir harus dalam format tanggal yang benar.',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 10MB'
        ]);

        $data = tb_ptk::findOrFail($id_ptk);

        if ($request->hasFile('foto')) {
            if (!empty($data->foto)) {
                $oldImagePath = public_path('img/guru/' . $data->foto);
                if (file_exists($oldImagePath) && !is_dir($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $imageName = $request->file('foto')->hashName();
            $request->file('foto')->move('img/guru', $imageName);
            $data->foto = $imageName;
        }
    
        $data->update([
            'nip' => $request->nip,
            'nuptk' => $request->nuptk,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        return redirect()->route('ptk.index', ['token' => $request->token])->with('success', 'PTK berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->route("ptk");
        $token = $request->session()->get('token') ?? $request->input('token');

        $ptk = tb_ptk::findOrFail($id);

        $imagePath = public_path('img/guru/' . $ptk->thumbnail);

        $ptk->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('ptk.index', ['token' => $request->token])->with('success', 'PTK berhasil dihapus.');
    }
}
