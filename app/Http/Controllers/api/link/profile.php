<?php

namespace App\Http\Controllers\api\link;

use App\Http\Controllers\Controller;
use App\Http\Resources\profileController;
use App\Models\url\tb_other;
use Illuminate\Http\Request;

class profile extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/profile/komite-sekolah",
     *     tags={"Sekolah"},
     *     summary="Get Komite Sekolah",
     *     description="Retrieve Komite Sekolah",
     *     operationId="getKomiteSekolah",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Data ditemukan",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="message", type="string", example="Data ditemukan"),
     *          @OA\Property(property="data", type="array",
     *
     *              @OA\Items(ref="#/components/schemas/ProfileData")
     *          )
     *      )
     *      ),
     * )
     */
    public function komiteSekolah(Request $request)
    {
        $data = tb_other::where('id_link', 4)->get();

        return response()->json([
            'message' => 'data ditemukan',
            'data' => profileController::collection($data),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile/program-kerja",
     *     tags={"Sekolah"},
     *     summary="Get Program Kerja Sekolah",
     *     description="Retrieve Program Kerja Sekolah",
     *     operationId="getProgramKerjaSekolah",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Data ditemukan",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Data ditemukan"),
     *          @OA\Property(property="data", type="array",
     *              @OA\Items(ref="#/components/schemas/ProfileData")
     *          )
     *  )
     *      ),
     * )
     */
    public function programKerja(Request $request)
    {
        $data = tb_other::where('id_link', 5)->get();

        return response()->json([
            'message' => 'data ditemukan',
            'data' => profileController::collection($data),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile/struktur-organisasi",
     *     tags={"Sekolah"},
     *     summary="Get Struktur Organisasi Sekolah",
     *     description="Retrieve Struktur Organisasi  Sekolah",
     *     operationId="getStrukturOrganisasiSekolah",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Data ditemukan",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Data ditemukan"),
     *          @OA\Property(property="data", type="array",
     *              @OA\Items(ref="#/components/schemas/ProfileData")
     *          )
     *  )
     *      ),
     * )
     */
    public function strukturOrganisasi(Request $request)
    {
        $data = tb_other::where('id_link', 7)->get();

        return response()->json([
            'message' => 'data ditemukan',
            'data' => profileController::collection($data),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile/visi-misi",
     *     tags={"Sekolah"},
     *     summary="Get Visi Misi Sekolah",
     *     description="Retrieve Visi Misi  Sekolah",
     *     operationId="getVisiMisiSekolah",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Data ditemukan",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Data ditemukan"),
     *          @OA\Property(property="data", type="array",
     *              @OA\Items(ref="#/components/schemas/ProfileData")
     *          )
     *  )
     *      ),
     * )
     */
    public function visiMisi(Request $request)
    {
        $data = tb_other::where('id_link', 6)->get();

        return response()->json([
            'message' => 'data ditemukan',
            'data' => profileController::collection($data),
        ]);
    }
}
