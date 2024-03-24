<?php

namespace App\Http\Controllers;

use App\Models\tb_admin;
use App\Models\tb_pengumuman;
use Illuminate\Http\Request;

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
    public function edit(string $id, Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $pengumuman = tb_pengumuman::find($id);
        if (!$pengumuman) {
            return redirect()->route('pengumuman.index')->with('error', 'Pengumuman not found.');
        }
    
        return view('admin.pengumuman.edit', [
            'menu_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
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
    public function destroy(string $id)
    {
        //
    }
}
