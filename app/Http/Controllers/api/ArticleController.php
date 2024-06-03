<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/articles",
     *     tags={"Articles"},
     *     summary="Get all articles",
     *     description="Retrieve all articles with type 1",
     *     operationId="getAllArticles",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/ArticleResource")
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
        // $artikel = tb_pemberitahuan::select('tb_pemberitahuan.*', 'tb_pemberitahuan_category.pemberitahuan_category_name')
        //     ->join('tb_pemberitahuan_category', 'tb_pemberitahuan.category', '=', 'tb_pemberitahuan_category.id_pemberitahuan_category')
        //     ->where(['tb_pemberitahuan.type'=> 1])
        //     ->orderBy('tb_pemberitahuan.created_at', 'desc')
        //     ->get();

        $artikel = tb_pemberitahuan::with('kategori')
        ->where('type', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => ArticleResource::collection($artikel),
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
     *     path="/api/user/articles/{id}",
     *     tags={"Articles"},
     *     summary="Get specific article",
     *     description="Retrieve a specific article by its ID",
     *     operationId="getArticleById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", ref="#/components/schemas/ArticleResource")
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
    public function show(string $id)
    {
        $artikel = tb_pemberitahuan::with('kategori')
        ->where('id_pemberitahuan', $id)
        ->where('type', 1)
        ->first();

        if (empty($artikel)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new ArticleResource($artikel),
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
     *     path="/api/user/articleCategories",
     *     tags={"Articles"},
     *     summary="Get all article categories",
     *     description="Retrieve all categories for articles",
     *     operationId="getArticleCategories",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CategoryResource")
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
    public function categoryArticle()
    {
        $data = tb_pemberitahuan_category::with('tipe')
        ->where('type', 1)
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => CategoryResource::collection($data),
        ], 200);
    }
}
