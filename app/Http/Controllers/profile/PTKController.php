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
        ], [
            'nip.required' => 'Kolom NIP harus diisi.',
            'nuptk.required' => 'Kolom NUPTK harus diisi.',
            'nama.required' => 'Kolom isi PTK harus diisi.',
            'tanggal_lahir.required' => 'Kolom tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Kolom tanggal lahir harus dalam format tanggal yang benar.',
            'tempat_lahir.required' => 'Kolom tempat lahir harus diisi.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin harus diisi.',
        ]);

        tb_ptk::create($request->all());
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
            'nip' => 'required',
            'nuptk' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ], [
            'nip.required' => 'Kolom NIP harus diisi.',
            'nuptk.required' => 'Kolom NUPTK harus diisi.',
            'nama.required' => 'Kolom isi PTK harus diisi.',
            'tanggal_lahir.required' => 'Kolom tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Kolom tanggal lahir harus dalam format tanggal yang benar.',
            'tempat_lahir.required' => 'Kolom tempat lahir harus diisi.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin harus diisi.',
        ]);

        $ptk = tb_ptk::findOrFail($id_ptk);
        $ptk->update($request->all());

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
        $ptk->delete();

        return redirect()->route('ptk.index', ['token' => $request->token])->with('success', 'PTK berhasil dihapus.');
    }
}
