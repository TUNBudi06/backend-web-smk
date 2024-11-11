<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PTKResource;
use App\Models\tb_ptk;
use Illuminate\Http\Request;

class PTKController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/profile/teachers",
     *     tags={"PTK"},
     *     summary="Get all PTK",
     *     description="Retrieve all PTK. Supports search by 'nama', 'nip', and 'nuptk'.",
     *     operationId="getAllPTK",
     *
     *     @OA\Parameter(
     *         name="search_nama",
     *         in="query",
     *         description="Search by nama",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search_nip",
     *         in="query",
     *         description="Search by NIP",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search_nuptk",
     *         in="query",
     *         description="Search by NUPTK",
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
     *                 @OA\Items(ref="#/components/schemas/PTKResource")
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
        $query = tb_ptk::query();

        # Search by nama
        if ($request->has('search_nama')) {
            $searchNama = $request->input('search_nama');
            $query->where('nama', 'LIKE', '%' . $searchNama . '%');
        }

        # Search by NIP
        if ($request->has('search_nip')) {
            $searchNip = $request->input('search_nip');
            $query->where('nip', 'LIKE', '%' . $searchNip . '%');
        }

        # Search by NUPTK
        if ($request->has('search_nuptk')) {
            $searchNuptk = $request->input('search_nuptk');
            $query->where('nuptk', 'LIKE', '%' . $searchNuptk . '%');
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => PTKResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataPTK = new tb_ptk;
        $dataPTK = tb_ptk::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Sukses menambahkan data',
            'data' => $dataPTK,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile/teachers/{id}",
     *     tags={"PTK"},
     *     summary="Get specific PTK",
     *     description="Retrieve a specific PTK by its ID",
     *     operationId="getPTKById",
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
     *             @OA\Property(property="data", ref="#/components/schemas/PTKResource")
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
        $ptk = tb_ptk::find($id);

        if (! $ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $ptk,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ptk = tb_ptk::find($id);

        if (! $ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $ptk->update($request->all());

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
        $ptk = tb_ptk::find($id);

        if (! $ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $imagePath = public_path('img/guru/'.$ptk->foto);

        $ptk->delete();
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
