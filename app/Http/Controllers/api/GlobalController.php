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
use App\Http\Resources\PDResource;
use App\Http\Resources\perangkatAjarResource;
use App\Http\Resources\PTKResource;
use App\Models\tb_extra;
use App\Models\tb_facilities;
use App\Models\tb_gallery;
use App\Models\tb_jurusan;
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
     *                 @OA\Property(property="ekstras", type="array", @OA\Items(ref="#/components/schemas/Ekstra")),
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
        $jurusans = tb_jurusan::where('jurusan_nama', 'LIKE', '%' . $query . '%')
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

        $data = [
            'articles' => $articles->isEmpty() ? ['icon_type' => 'Articles'] : ArticleResource::collection($articles),
            'announcements' => $announcements->isEmpty() ? ['icon_type' => 'Announcement'] : AnnouncementResource::collection($announcements),
            'news' => $news->isEmpty() ? ['icon_type' => 'News'] : NewsResource::collection($news),
            'events' => $events->isEmpty() ? ['icon_type' => 'Event'] : EventResource::collection($events),
            'ekstras' => $ekstras->isEmpty() ? ['icon_type' => 'Ekstra'] : EkstraResource::collection($ekstras),
            'facilities' => $facilities->isEmpty() ? ['icon_type' => 'Facilities'] : FasilitasResource::collection($facilities),
            'galleries' => $galleries->isEmpty() ? ['icon_type' => 'Gallery'] : GalleryResource::collection($galleries),
            'jurusans' => $jurusans->isEmpty() ? ['icon_type' => 'Jurusan'] : JurusanResource::collection($jurusans),
            'pa' => $pa->isEmpty() ? ['icon_type' => 'Perangkat Ajar'] : perangkatAjarResource::collection($pa),
            'pd' => $pd->isEmpty() ? ['icon_type' => 'Peserta Didik'] : PDResource::collection($pd),
            'ptk' => $ptk->isEmpty() ? ['icon_type' => 'PTK'] : PTKResource::collection($ptk),
            'kemitraan' => $kemitraan->isEmpty() ? ['icon_type' => 'Kemitraan'] : KemitraanResource::collection($kemitraan),
            'lokers' => $lokers->isEmpty() ? ['icon_type' => 'Loker'] : LokerResource::collection($lokers),
        ];
    
        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $data
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
