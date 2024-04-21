<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PTKResource;
use App\Models\tb_ptk;
use Illuminate\Http\Request;

class PTKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = tb_ptk::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => PTKResource::collection($data),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataPTK = new tb_ptk();
        $dataPTK = tb_ptk::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Sukses menambahkan data',
            'data' => $dataPTK,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ptk = tb_ptk::find($id);

        if (!$ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $ptk,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ptk = tb_ptk::find($id);

        if (!$ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        $ptk->update($request->all());
    
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ptk = tb_ptk::find($id);

        if (!$ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        $ptk->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
