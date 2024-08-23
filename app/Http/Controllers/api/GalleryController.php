<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryGalleryResource;
use App\Http\Resources\GalleryResource;
use App\Models\tb_category_gallery;
use App\Models\tb_gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/galleries",
     *     tags={"Gallery"},
     *     summary="Get all Gallery",
     *     description="Retrieve all Gallery",
     *     operationId="getAllGaleri",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/Gallery")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = tb_gallery::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => GalleryResource::collection($data),
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
     *     path="/api/user/galleries/{id}",
     *     tags={"Gallery"},
     *     summary="Get galleries by ID",
     *     description="Retrieve a single galleries entry by ID",
     *     operationId="getGaleriById",
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
     *         @OA\JsonContent(ref="#/components/schemas/Gallery")
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
        $data = tb_gallery::where('id_gallery', $id)
            ->first();

        if (empty($data)) {
            return response()->json([
                'data' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new GalleryResource($data),
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

    /**
     * @OA\Get(
     *     path="/api/user/gallery-categories",
     *     tags={"Gallery"},
     *     summary="Get gallery categories",
     *     description="Retrieve categories of gallery",
     *     operationId="getGaleriCategories",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/CategoryGalleryResource")
     *         )
     *     )
     * )
     */
    public function categoryGaleri()
    {
        $data = tb_category_gallery::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => CategoryGalleryResource::collection($data),
        ], 200);
    }
}
