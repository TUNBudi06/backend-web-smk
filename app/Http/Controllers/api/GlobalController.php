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
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Perform search in all tables
        $articles = tb_pemberitahuan::where('type', 1)
            ->where('nama', 'LIKE', '%'.$query.'%')
            ->get();

        $announcements = tb_pemberitahuan::where('type', 2)
            ->where('nama', 'LIKE', '%'.$query.'%')
            ->get();

        $news = tb_pemberitahuan::where('type', 3)
            ->where('nama', 'LIKE', '%'.$query.'%')
            ->get();

        $events = tb_pemberitahuan::where('type', 4)
            ->where('nama', 'LIKE', '%'.$query.'%')
            ->get();

        $ekstras = tb_extra::where('extra_name', 'LIKE', '%'.$query.'%')
            ->get();

        $facilities = tb_facilities::where('facility_name', 'LIKE', '%'.$query.'%')
            ->get();

        $galleries = tb_gallery::where('gallery_title', 'LIKE', '%'.$query.'%')
            ->get();

        $jurusans = tb_jurusan::where('jurusan_nama', 'LIKE', '%'.$query.'%')
            ->get();

        $pa = tb_perangkatAjar::where('title', 'LIKE', '%'.$query.'%')
            ->get();

        $pd = tb_peserta_didik::where('nama', 'LIKE', '%'.$query.'%')
            ->get();

        $kemitraan = tb_kemitraan::where('kemitraan_name', 'LIKE', '%'.$query.'%')
            ->get();

        $lokers = tb_loker::with('position', 'kemitraan')
            ->where('loker_description', 'LIKE', '%'.$query.'%')
            ->get();

        $ptk = tb_ptk::where('nama', 'LIKE', '%'.$query.'%')
            ->get();

        $list_var = [
            'articles' => ArticleResource::class,
            'announcements' => AnnouncementResource::class,
            'news' => NewsResource::class,
            'events' => EventResource::class,
            'ekstras' => EkstraResource::class,
            'facilities' => FasilitasResource::class,
            'galleries' => GalleryResource::class,
            'jurusans' => JurusanResource::class,
            'pa' => perangkatAjarResource::class,
            'pd' => PDResource::class,
            'ptk' => PTKResource::class,
            'kemitraan' => KemitraanResource::class,
            'lokers' => LokerResource::class,
        ];

        $data = [];
        foreach ($list_var as $index => $var) {
            if (! $$index->isEmpty()) {
                $data = array_merge($data, $var::collection($$index)->toArray($request));
            }
        }

        $data = array_slice($data, 0, 10);

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $data,
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
