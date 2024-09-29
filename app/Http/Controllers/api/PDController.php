<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PDResource;
use App\Models\tb_peserta_didik;
use Illuminate\Http\Request;

class PDController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/profile/students",
     *     tags={"PD"},
     *     summary="Get all peserta didik",
     *     description="Retrieve all peserta didik. Supports search by 'nama' and 'kelas'.",
     *     operationId="getAllPesertaDidik",
     *
     *     @OA\Parameter(
     *         name="search_nama",
     *         in="query",
     *         description="Search by nama",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search_kelas",
     *         in="query",
     *         description="Search by kelas",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/PDResource")
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
        $query = tb_peserta_didik::query();

        # Search by nama
        if ($request->has('search_nama')) {
            $searchNama = $request->input('search_nama');
            $query->where('nama', 'LIKE', '%' . $searchNama . '%');
        }

        # Search by kelas
        if ($request->has('search_kelas')) {
            $searchKelas = $request->input('search_kelas');
            $query->where('kelas', 'LIKE', '%' . $searchKelas . '%');
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => PDResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataPeserta_didik = new tb_peserta_didik;
        $dataPeserta_didik = tb_peserta_didik::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Sukses menambahkan data',
            'data' => $dataPeserta_didik,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile/students/{id}",
     *     tags={"PD"},
     *     summary="Get specific peserta didik",
     *     description="Retrieve a specific peserta didik by its ID",
     *     operationId="getPesertaDidikById",
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
     *             @OA\Property(property="data", ref="#/components/schemas/PDResource")
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
        $peserta_didik = tb_peserta_didik::find($id);

        if (! $peserta_didik) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $peserta_didik,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peserta_didik = tb_peserta_didik::find($id);

        if (! $peserta_didik) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $peserta_didik->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peserta_didik = tb_peserta_didik::find($id);

        if (! $peserta_didik) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $peserta_didik->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
