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
        $perPage = 10;
        $pengumuman = tb_pengumuman::paginate($perPage);

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
        ]);

        tb_pengumuman::create($request->all());
        return redirect()->route('pengumuman.index', ['token' => $token])->with('success', 'Data added successfully.');
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
        ]);

        $pengumuman = tb_pengumuman::findOrFail($id_pengumuman);
        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index', ['token' => $request->token])->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_pengumuman = $request->route("pengumuman");
        $token = $request->session()->get('token') ?? $request->input('token');

//        $pengumuman = tb_pengumuman::findOrFail($id_pengumuman);
//        $pengumuman->delete();

    }
}
