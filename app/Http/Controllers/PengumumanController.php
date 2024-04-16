<?php

namespace App\Http\Controllers;

use App\Models\tb_admin;
use Illuminate\Http\Request;
use App\Models\tb_pengumuman;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $pengumuman = tb_pengumuman::orderBy('pengumuman_timestamp', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.pengumuman.index', [
            'menu_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.pengumuman.create', [
            'menu_active' => 'pengumuman',
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
            'pengumuman_nama' => 'required',
            'pengumuman_target' => 'required',
            'pengumuman_text' => 'required',
            'pengumuman_date' => 'required|date',
            'pengumuman_time' => 'required',
        ], [
            'pengumuman_nama.required' => 'Kolom nama pengumuman harus diisi.',
            'pengumuman_target.required' => 'Kolom target pengumuman harus diisi.',
            'pengumuman_text.required' => 'Kolom isi pengumuman harus diisi.',
            'pengumuman_date.required' => 'Kolom tanggal pengumuman harus diisi.',
            'pengumuman_date.date' => 'Kolom tanggal pengumuman harus dalam format tanggal yang benar.',
            'pengumuman_time.required' => 'Kolom waktu pengumuman harus diisi.',
        ]);

        tb_pengumuman::create($request->all());
        return redirect()->route('pengumuman.index', ['token' => $token])->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_pengumuman = $request->route("pengumuman");
        $token = $request->session()->get('token') ?? $request->input('token');
        $pengumuman = tb_pengumuman::findOrFail($id_pengumuman);

        return view('admin.pengumuman.show', [
            'menu_active' => 'pengumuman',
            'profile_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_pengumuman = $request->route("pengumuman");
        $token = $request->session()->get('token') ?? $request->input('token');
        $pengumuman = tb_pengumuman::findOrFail($id_pengumuman);
        return view('admin.pengumuman.edit', [
            'menu_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_pengumuman = $request->route("pengumuman");
        $request->validate([
            'pengumuman_nama' => 'required',
            'pengumuman_target' => 'required',
            'pengumuman_text' => 'required',
            'pengumuman_date' => 'required|date',
            'pengumuman_time' => 'required',
        ], [
            'pengumuman_nama.required' => 'Kolom nama pengumuman harus diisi.',
            'pengumuman_target.required' => 'Kolom target pengumuman harus diisi.',
            'pengumuman_text.required' => 'Kolom isi pengumuman harus diisi.',
            'pengumuman_date.required' => 'Kolom tanggal pengumuman harus diisi.',
            'pengumuman_date.date' => 'Kolom tanggal pengumuman harus dalam format tanggal yang benar.',
            'pengumuman_time.required' => 'Kolom waktu pengumuman harus diisi.',
        ]);

        $pengumuman = tb_pengumuman::findOrFail($id_pengumuman);
        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index', ['token' => $request->token])->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_pengumuman = $request->route("pengumuman");
        $token = $request->session()->get('token') ?? $request->input('token');

       $pengumuman = tb_pengumuman::findOrFail($id_pengumuman);
       $pengumuman->delete();

       return redirect()->route('pengumuman.index', ['token' => $request->token])->with('success', 'Pengumuman berhasil dihapus.');

    }
}
