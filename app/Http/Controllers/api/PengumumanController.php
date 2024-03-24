<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengumumanResource;
use App\Models\tb_pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = tb_pengumuman::get();

        return response()->json([
            'message' => 'Data ditemukan',
            // 'data' => $data
            'data' => PengumumanResource::collection($data),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataPengumuman = new tb_pengumuman();
        
        $dataPengumuman = tb_pengumuman::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Sukses menambahkan data',
            'data' => $dataPengumuman,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
