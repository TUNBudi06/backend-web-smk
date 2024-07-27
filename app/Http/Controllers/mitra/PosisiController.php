<?php

namespace App\Http\Controllers\mitra;

use App\Http\Controllers\Controller;
use App\Models\tb_position;
use Illuminate\Http\Request;

class PosisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $positions = tb_position::get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.posisi.index', [
            'menu_active' => 'kemitraan',
            'action' => $action,
            'positions' => $positions,
            'token' => $token,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $request->session()->put('update', 'create');
        return redirect()->route('posisi.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required',
            'position_type' => 'required',
        ]);

        $positions = new tb_position();
        $positions->position_name = $request->position_name;
        $positions->position_type = $request->position_type;
        $positions->save();

        return redirect()->route('posisi.index', ['token' => $request->token])->with('success', 'Posisi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_position = $request->route("posisi");
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token',$token);
        $positions = tb_position::findOrFail($id_position);
        $data = [
            'positions' => $positions,
            'update' => $action,
        ];
        return redirect()->route("posisi.index",$token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'position_name' => 'required',
            'position_type' => 'required',
        ]);
        $position = $request->route("posisi");

        // Update data position
        $position = tb_position::findOrFail($position);
        $position->update([
            'position_name' => $request->position_name,
            'position_type' => $request->position_type,
        ]);

        return redirect()->route('posisi.index', ['token' => $request->token])->with('success', 'Posisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_position = $request->route("posisi");
        $token = $request->session()->get('token') ?? $request->input('token');

       $position = tb_position::findOrFail($id_position);
       $position->delete();

        return redirect()->route('posisi.index', ['token' => $token])->with('success', 'Posisi berhasil dihapus.');
    }
}