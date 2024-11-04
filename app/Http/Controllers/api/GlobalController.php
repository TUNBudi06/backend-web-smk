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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;

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

        $data = Cache::flexible('global_search_'.$query, [60 * 30, 60 * 60 * 2], function () use ($query, $request) {
            // Perform search in all tables using concurrency
            [$articles, $announcements, $news, $events, $ekstras, $facilities, $galleries, $jurusans, $pa, $pd, $kemitraan, $lokers, $ptk] = Concurrency::run([
                fn () => tb_pemberitahuan::where('type', 1)
                    ->where('nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => ArticleResource::collection($data)),

                fn () => tb_pemberitahuan::where('type', 2)
                    ->where('nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => AnnouncementResource::collection($data)),

                fn () => tb_pemberitahuan::where('type', 3)
                    ->where('nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => NewsResource::collection($data)),

                fn () => tb_pemberitahuan::where('type', 4)
                    ->where('nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => EventResource::collection($data)),

                fn () => tb_extra::where('extra_name', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => EkstraResource::collection($data)),

                fn () => tb_facilities::where('facility_name', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => FasilitasResource::collection($data)),

                fn () => tb_gallery::where('gallery_title', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => GalleryResource::collection($data)),

                fn () => tb_jurusan::where('jurusan_nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => JurusanResource::collection($data)),

                fn () => tb_perangkatAjar::where('title', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => perangkatAjarResource::collection($data)),

                fn () => tb_peserta_didik::where('nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => PDResource::collection($data)),

                fn () => tb_kemitraan::where('kemitraan_name', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => KemitraanResource::collection($data)),

                fn () => tb_loker::with('position', 'kemitraan')
                    ->where('loker_description', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => LokerResource::collection($data)),

                fn () => tb_ptk::where('nama', 'LIKE', '%'.$query.'%')
                    ->get()
                    ->whenNotEmpty(fn ($data) => PTKResource::collection($data)),
            ]);

            // Initialize an empty array to hold the merged data
            $data = [];

            // Merge all non-empty results
            foreach ([$articles, $announcements, $news, $events, $ekstras, $facilities, $galleries, $jurusans, $pa, $pd, $kemitraan, $lokers, $ptk] as $result) {
                if ($result) {
                    $data = array_merge($data, $result->toArray($request));
                }
            }

            // Limit the results to the first 10 items
            return array_slice($data, 0, 10);
        });

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
