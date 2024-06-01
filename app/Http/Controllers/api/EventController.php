<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\EventResource;
use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = tb_pemberitahuan::with('kategori')
        ->where('type', 4)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => EventResource::collection($event),
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
        $news = tb_pemberitahuan::with('kategori')
        ->where('id_pemberitahuan', $id)
        ->where('type', 4)
        ->first();

        if (empty($news)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new EventResource($news),
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

    public function categoryEvent()
    {
        $data = tb_pemberitahuan_category::with('tipe')
        ->where('type', 4)
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => CategoryResource::collection($data),
        ], 200);
    }
}
