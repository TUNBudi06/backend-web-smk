<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PosisiResource;
use App\Models\tb_position;
use Illuminate\Http\Request;

class PosisiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/position",
     *     tags={"Position"},
     *     summary="Get all Position",
     *     description="Retrieve all Position",
     *     operationId="getAllPosition",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Position")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = tb_position::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => PosisiResource::collection($data),
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
     *     path="/api/user/position/{id}",
     *     tags={"Position"},
     *     summary="Get Position by ID",
     *     description="Retrieve a single Position entry by ID",
     *     operationId="getPositionById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/Position")
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
    public function show(string $id)
    {
        $data = tb_position::where('id_position', $id)
            ->first();

        if (empty($data)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new PosisiResource($data),
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
