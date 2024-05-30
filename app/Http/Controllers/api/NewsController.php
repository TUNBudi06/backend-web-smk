<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\tb_pemberitahuan;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = tb_pemberitahuan::with('kategori')
        ->where('type', 3)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => NewsResource::collection($news),
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
        ->where('type', 3)
        ->first();

        if (empty($news)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new NewsResource($news),
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
