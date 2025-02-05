<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NewsResource;
use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/news",
     *     tags={"News"},
     *     summary="Get all news data with pagination",
     *     description="Retrieve all news data. Supports search by 'nama' and filtering by date range using 'created_at'. Results are paginated with 9 items per page.",
     *     operationId="getAllNews",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for news names",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="search_category",
     *         in="query",
     *         description="Search keyword for news category names",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Start date for filtering news (format: YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="End date for filtering news (format: YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *
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
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             ),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=9),
     *                 @OA\Property(property="total", type="integer", example=100),
     *                 @OA\Property(property="last_page", type="integer", example=12),
     *                 @OA\Property(property="next_page_url", type="string", example="http://api.example.com/api/user/news?page=2"),
     *                 @OA\Property(property="prev_page_url", type="string", example="http://api.example.com/api/user/news?page=1")
     *             )
     *         )
     *     ),
     *
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
            ->where('type', 3)
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

        $berita = $query->orderBy('created_at', 'desc')->paginate(9);

        if ($berita->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => NewsResource::collection($berita),
            'pagination' => [
                'current_page' => $berita->currentPage(),
                'per_page' => $berita->perPage(),
                'total' => $berita->total(),
                'last_page' => $berita->lastPage(),
                'next_page_url' => $berita->nextPageUrl(),
                'prev_page_url' => $berita->previousPageUrl(),
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
     *     path="/api/user/news/{id}",
     *     tags={"News"},
     *     summary="Get news by ID",
     *     description="Retrieve a single news entry by ID",
     *     operationId="getNewsById",
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
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
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
        $news = tb_pemberitahuan::with('kategori')
            ->where('id_pemberitahuan', $id)
            ->where('type', 3)
            ->first();

        if (empty($news)) {
            return response()->json([
                'data' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new NewsResource($news),
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
     *     path="/api/user/news-categories",
     *     tags={"News"},
     *     summary="Get news categories",
     *     description="Retrieve categories of news",
     *     operationId="getNewsCategories",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/CategoryResource")
     *         )
     *     )
     * )
     */
    public function categoryNews()
    {
        $data = tb_pemberitahuan_category::with('tipe')
            ->where('type', 3)
            ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => CategoryResource::collection($data),
        ], 200);
    }
}
