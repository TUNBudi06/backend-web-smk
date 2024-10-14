<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LokerResource;
use App\Models\tb_loker;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/lokers",
     *     tags={"Loker"},
     *     summary="Get all Loker",
     *     description="Retrieve all Loker data. Supports search by 'position_name' and filter by 'loker_for'.",
     *     operationId="getAllLoker",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for Position names",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search_requirement",
     *         in="query",
     *         description="Search keyword for Loker Requirement (loker_for)",
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
     *                 @OA\Items(ref="#/components/schemas/LokerResource")
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
        $query = tb_loker::with(['position', 'kemitraan']);

        // Search by kemitraan_name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('position', function ($query) use ($search) {
                $query->where('position_name', 'LIKE', '%' . $search . '%');
            });
        }

        // Search by requirement
        if ($request->has('search_requirement')) {
            $search = $request->input('search_requirement');
            $query->where('loker_for', 'LIKE', '%'.$search.'%');
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => LokerResource::collection($data),
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
     *     path="/api/user/lokers/{id}",
     *     tags={"Loker"},
     *     summary="Get Loker by ID",
     *     description="Retrieve a single Loker entry by ID",
     *     operationId="getLokerById",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(ref="#/components/schemas/LokerResource")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $data = tb_loker::where('id_loker', $id)
            ->first();

        if (empty($data)) {
            return response()->json([
                'data' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new LokerResource($data),
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
