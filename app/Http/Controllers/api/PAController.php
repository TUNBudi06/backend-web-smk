<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\perangkatAjarResource;
use App\Models\tb_perangkatAjar;
use Illuminate\Http\Request;

class PAController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/PerangkatAjar",
     *     tags={"Perangkat Ajar"},
     *     summary="Get all Perangkat Ajar",
     *     description="Retrieve all Perangkat Ajar with type 1. Supports search by 'nama' and 'kelas'.",
     *     operationId="getAllPerangkatAjar",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for Materi Bahan Ajar",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="kelas",
     *         in="query",
     *         description="Search keyword for class Materi Bahan Ajar",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/PerangkatAjarResource")
     *             )
     *         )
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
    public function index(Request $request)
    {
        $query = tb_perangkatAjar::orderBy('created_at', 'desc');

        // Search by name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', '%'.$search.'%');
        }

        // Filter by date range
        if ($request->has('kelas')) {
            $kelas = $request->input('kelas');
            $query->where('title', 'LIKE', '%'.$kelas.'%');
        }

        $pa_data = $query->get();

        if ($pa_data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => perangkatAjarResource::collection($pa_data),
        ], 200);
    }
}
