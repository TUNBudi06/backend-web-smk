<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EkstraResource;
use App\Models\tb_extra;
use Illuminate\Http\Request;

class EkstraController extends Controller
{
        /**
     * @OA\Get(
     *     path="/api/user/profile/ekstras",
     *     tags={"Ekstra"},
     *     summary="Get all Ekstra",
     *     description="Retrieve all Ekstra",
     *     operationId="getAllEkstra",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Ekstra")
     *             )
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/user/profile/ekstras/{id}",
     *     tags={"Ekstra"},
     *     summary="Get specific Ekstra",
     *     description="Retrieve a specific Ekstra by ID",
     *     operationId="getEkstraById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Ekstra",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", ref="#/components/schemas/Ekstra")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="string", example="Data tidak ditemukan")
     *         )
     *     )
     * )
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
