<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\EkstraResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\FasilitasResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\JurusanResource;
use App\Http\Resources\KemitraanResource;
use App\Http\Resources\LokerResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\perangkatAjarResource;
use App\Models\tb_extra;
use App\Models\tb_facilities;
use App\Models\tb_gallery;
use App\Models\tb_kemitraan;
use App\Models\tb_loker;
use App\Models\tb_pemberitahuan;
use App\Models\tb_perangkatAjar;
use App\Models\tb_peserta_didik;
use App\Models\tb_ptk;
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
     *                 @OA\Property(property="ekstras", type="array", @OA\Items(ref="#/components/schemas/EkstraResource")),
     *                 @OA\Property(property="facilities", type="array", @OA\Items(ref="#/components/schemas/FasilitasResource")),
     *                 @OA\Property(property="galleries", type="array", @OA\Items(ref="#/components/schemas/Gallery")),
     *                 @OA\Property(property="jurusans", type="array", @OA\Items(ref="#/components/schemas/Jurusan")),
     *                 @OA\Property(property="pa", type="array", @OA\Items(ref="#/components/schemas/PerangkatAjarResource")),
     *                 @OA\Property(property="pd", type="array", @OA\Items(ref="#/components/schemas/PDResource")),
     *                 @OA\Property(property="ptk", type="array", @OA\Items(ref="#/components/schemas/PTKResource")),
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

        // Search in Ekstra
        $ekstras = tb_extra::where('extra_name', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Facility
        $facilities = tb_facilities::where('facility_name', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Gallery
        $galleries = tb_gallery::where('gallery_title', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Jurusan
        $jurusans = tb_kemitraan::where('jurusan_nama', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Perangkat Ajar
        $pa = tb_perangkatAjar::where('title', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in PD
        $pd = tb_peserta_didik::where('nama', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Kemitraan
        $kemitraan = tb_kemitraan::where('kemitraan_name', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in Loker
        $lokers = tb_loker::with('position', 'kemitraan')
            ->where('loker_type', 'LIKE', '%' . $query . '%')
            ->get();

        // Search in PTK
        $ptk = tb_ptk::where('nama', 'LIKE', '%' . $query . '%')
            ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => [
                'articles' => ArticleResource::collection($articles),
                'announcements' => AnnouncementResource::collection($announcements),
                'news' => NewsResource::collection($news),
                'events' => EventResource::collection($events),
                'ekstras' => EkstraResource::collection($ekstras),
                'facilities' => FasilitasResource::collection($facilities),
                'galleries' => GalleryResource::collection($galleries),
                'jurusans' => JurusanResource::collection($jurusans),
                'pa' => perangkatAjarResource::collection($pa),
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
