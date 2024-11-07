<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogoKResource;
use App\Models\tb_logo_mitra;
use Illuminate\Http\Request;

class LogokController extends Controller
{
    /**
     * Get all Logo Kemitraan
     *
     * @OA\Get(
     *     path="/api/user/logo/kemitraan",
     *     tags={"Kemitraan"},
     *     summary="Retrieve all logo kemitraan data",
     *     operationId="getLogok",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data logok berhasil diambil"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/LogoKResource")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function getLogok(Request $request)
    {
        $logok = tb_logo_mitra::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data logok berhasil diambil',
            'data' => LogoKResource::collection($logok),
        ], 200);
    }
}
