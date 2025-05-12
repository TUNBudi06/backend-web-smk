<?php

namespace App\Http\Controllers\api\link;

use App\Http\Controllers\Controller;
use App\Http\Resources\link\BasicResource;
use App\Http\Resources\link\NavbarResource;
use App\Models\BasicInformationModel;
use App\Models\tb_navbar;

class BasicApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/profile-basic",
     *     tags={"Sekolah"},
     *     summary="Get basic information as email,phone, etc",
     *     description="This provide information about basic profile",
     *     operationId="getBasicProfile",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="message", type="string", example="data ditemukan"),
     *             @OA\Property(
     *                 property="List",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/BasicResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $navbar = BasicInformationModel::get();

        return response()->json([
            'message' => 'data ditemukan',
            'List' => BasicResource::collection($navbar),
        ]);
    }
}
