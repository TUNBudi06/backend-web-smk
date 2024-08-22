<?php

namespace App\Http\Controllers\link;

use App\Http\Controllers\Controller;
use App\Http\Resources\link\AlertResource;
use App\Http\Resources\link\VideoResource;
use App\Models\url\tb_alert;
use App\Models\url\tb_video;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/link/alerts",
     *     tags={"Links"},
     *     summary="Get alert",
     *     description="Retrieve alert",
     *     operationId="getAlert",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/AlertResource")
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
    public function linkAlert()
    {
        $data = tb_alert::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => AlertResource::collection($data),
        ], 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/user/link/videos",
     *     tags={"Videos"},
     *     summary="Get video",
     *     description="Retrieve video",
     *     operationId="getVideo",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/AlertResource")
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
    public function linkVideo()
    {
        $data = tb_video::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => VideoResource::collection($data),
        ], 200);
    }
}
