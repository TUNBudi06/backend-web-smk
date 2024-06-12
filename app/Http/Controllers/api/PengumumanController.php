<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengumumanRequest;
use App\Http\Resources\AnnouncementResource;
use App\Http\Resources\CategoryResource;
use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/announcements",
     *     tags={"Announcement"},
     *     summary="Get all announcements",
     *     description="Retrieve all announcements with type 2",
     *     operationId="getAllAnnouncements",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Announcement")
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
    public function index()
    {
        $pengumuman = tb_pemberitahuan::with('kategori')
        ->where('type', 2)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => AnnouncementResource::collection($pengumuman),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengumumanRequest $request)
    {
        // $dataPengumuman = new tb_pengumuman();
        
        // $dataPengumuman = tb_pengumuman::create($request->all());

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Sukses menambahkan data',
        //     'data' => $dataPengumuman,
        // ],200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/announcements/{id}",
     *     tags={"Announcement"},
     *     summary="Get specific announcement",
     *     description="Retrieve a specific announcement by its ID",
     *     operationId="getAnnouncementById",
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
     *             @OA\Property(property="data", ref="#/components/schemas/Announcement")
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
        $pengumuman = tb_pemberitahuan::with('kategori')
        ->where('id_pemberitahuan', $id)
        ->where('type', 2)
        ->first();

        if (empty($pengumuman)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new AnnouncementResource($pengumuman),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengumumanRequest $request, string $id)
    {
        // $pengumuman = tb_pengumuman::find($id);

        // if (!$pengumuman) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Data tidak ditemukan',
        //     ], 404);
        // }
    
        // $pengumuman->update($request->all());
    
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data berhasil diperbarui',
        // ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $pengumuman = tb_pengumuman::find($id);

        // if (!$pengumuman) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Data tidak ditemukan',
        //     ], 404);
        // }
    
        // $pengumuman->delete();
    
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data berhasil dihapus',
        // ], 200);
    }

        /**
     * @OA\Get(
     *     path="/api/user/announcement-categories",
     *     tags={"Announcement"},
     *     summary="Get all announcement categories",
     *     description="Retrieve all categories for announcements",
     *     operationId="getAnnouncementCategories",
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
    public function categoryAnnouncement()
    {
        $data = tb_pemberitahuan_category::with('tipe')
        ->where('type', 2)
        ->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => CategoryResource::collection($data),
        ], 200);
    }
}
