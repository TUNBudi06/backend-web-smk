<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgendaResource;
use App\Models\tb_event;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = tb_event::get();

        return response()->json([
            'message' => 'Data ditemukan',
            // 'data' => $data
            'data' => AgendaResource::collection($data),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataAgenda = new tb_event();
        $dataAgenda = tb_event::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Sukses menambahkan data',
            'data' => $dataAgenda,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agenda = tb_event::find($id);

        if (!$agenda) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $agenda,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $agenda = tb_event::find($id);

        if (!$agenda) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        $agenda->update($request->all());
    
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
        $agenda = tb_event::find($id);

        if (!$agenda) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        $agenda->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
