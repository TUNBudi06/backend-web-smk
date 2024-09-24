<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\KemitraanResource;
use App\Http\Resources\LokerResource;
use App\Http\Resources\NewsResource;
use App\Models\tb_kemitraan;
use App\Models\tb_loker;
use App\Models\tb_pemberitahuan;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/search",
     *     tags={"Global Search"},
     *     summary="Search globally across multiple tables",
     *     description="Perform a search for all section",
     *     operationId="globalSearch",
     *
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         description="Search keyword",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="articles", type="array", @OA\Items(ref="#/components/schemas/ArticleResource")),
     *                 @OA\Property(property="announcements", type="array", @OA\Items(ref="#/components/schemas/AnnouncementResource")),
     *                 @OA\Property(property="news", type="array", @OA\Items(ref="#/components/schemas/NewsResource")),
     *                 @OA\Property(property="events", type="array", @OA\Items(ref="#/components/schemas/EventResource")),
     *                 @OA\Property(property="kemitraan", type="array", @OA\Items(ref="#/components/schemas/KemitraanResource")),
     *                 @OA\Property(property="lokers", type="array", @OA\Items(ref="#/components/schemas/LokerResource")),
     *             )
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Search in Artikel
        $articles = tb_pemberitahuan::where('type', 1)
            ->where('nama', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Announcement
        $announcements = tb_pemberitahuan::where('type', 2)
            ->where('nama', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Berita
        $news = tb_pemberitahuan::where('type', 3)
            ->where('nama', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Event
        $events = tb_pemberitahuan::where('type', 4)
            ->where('nama', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Kemitraan
        $kemitraan = tb_kemitraan::where('kemitraan_name', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Loker
        $lokers = tb_loker::with('position', 'kemitraan')
            ->where('loker_type', 'LIKE', '%' . $query . '%')
            ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => [
                'articles' => ArticleResource::collection($articles),
                'announcements' => AnnouncementResource::collection($announcements),
                'news' => NewsResource::collection($news),
                'events' => EventResource::collection($events),
                'kemitraan' => KemitraanResource::collection($kemitraan),
                'lokers' => LokerResource::collection($lokers),
            ],
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
