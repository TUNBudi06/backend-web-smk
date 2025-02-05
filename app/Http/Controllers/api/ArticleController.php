<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/articles",
     *     tags={"Articles"},
     *     summary="Get all articles with pagination",
     *     description="Retrieve all articles with type 1, supports search and filtering. Results are paginated with 9 items per page.",
     *     operationId="getAllArticles",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for article names",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search_category",
     *         in="query",
     *         description="Search keyword for category article names",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Start date for filtering articles (format: YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="End date for filtering articles (format: YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", format="int32")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/ArticleResource")
     *             ),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=9),
     *                 @OA\Property(property="total", type="integer", example=100),
     *                 @OA\Property(property="last_page", type="integer", example=12),
     *                 @OA\Property(property="next_page_url", type="string", example="http://api.example.com/api/user/articles?page=2"),
     *                 @OA\Property(property="prev_page_url", type="string", example="http://api.example.com/api/user/articles?page=1")
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
        $query = tb_pemberitahuan::with(['kategori', 'publishedUser'])
            ->where('type', 1)
            ->where('approved', 1);

        // Search by name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama', 'LIKE', '%'.$search.'%');
        }

        if ($request->has('search_category')) {
            $searchCategory = $request->input('search_category');
            $query->whereHas('kategori', function ($q) use ($searchCategory) {
                $q->where('pemberitahuan_category_name', 'LIKE', '%'.$searchCategory.'%');
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $artikel = $query->orderBy('created_at', 'desc')->paginate(9);

        if ($artikel->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => ArticleResource::collection($artikel),
            'pagination' => [
                'current_page' => $artikel->currentPage(),
                'per_page' => $artikel->perPage(),
                'total' => $artikel->total(),
                'last_page' => $artikel->lastPage(),
                'next_page_url' => $artikel->nextPageUrl(),
                'prev_page_url' => $artikel->previousPageUrl(),
            ]
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
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", ref="#/components/schemas/ArticleResource")
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
    public function show(string $id)
    {
        $artikel = tb_pemberitahuan::with('kategori')
            ->where('id_pemberitahuan', $id)
            ->where('type', 1)
            ->first();

        if (empty($artikel)) {
            return response()->json([
                'data' => 'Data tidak ditemukan',
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
     *     path="/api/user/article-categories",
     *     tags={"Articles"},
     *     summary="Get all article categories",
     *     description="Retrieve all categories for articles",
     *     operationId="getArticle-categories",
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
     *                 @OA\Items(ref="#/components/schemas/CategoryResource")
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
