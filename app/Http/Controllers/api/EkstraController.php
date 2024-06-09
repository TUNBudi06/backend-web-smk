<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EkstraResource;
use App\Models\tb_extra;
use Illuminate\Http\Request;

class EkstraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = tb_extra::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => EkstraResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = tb_extra::where('id_extra', $id)
            ->first();

        if (empty($data)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new EkstraResource($data),
        ], 200);
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
