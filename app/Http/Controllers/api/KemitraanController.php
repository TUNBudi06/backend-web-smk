<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KemitraanResource;
use App\Models\tb_kemitraan;
use Illuminate\Http\Request;

class KemitraanController extends Controller
{
/**
     * @OA\Get(
     *     path="/api/user/kemitraans",
     *     tags={"Kemitraan"},
     *     summary="Get all Kemitraan",
     *     description="Retrieve all Kemitraan data. Supports search by 'kemitraan_name'.",
     *     operationId="getAllKemitraan",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for Kemitraan names",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/KemitraanResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = tb_kemitraan::query();

        // Search by kemitraan_name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('kemitraan_name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => KemitraanResource::collection($data),
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
     * @OA\Get(
     *     path="/api/user/kemitraans/{id_kemitraan}",
     *     tags={"Kemitraan"},
     *     summary="Get specific Kemitraan",
     *     description="Retrieve a specific Kemitraan by ID",
     *     operationId="getKemitraanById",
     *
     *     @OA\Parameter(
     *         name="id_kemitraan",
     *         in="path",
     *         description="ID of the Kemitraan",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", ref="#/components/schemas/KemitraanResource")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="data", type="string", example="Data tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $data = tb_kemitraan::where('id_kemitraan', $id)
            ->first();

        if (empty($data)) {
            return response()->json([
                'data' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new KemitraanResource($data),
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
