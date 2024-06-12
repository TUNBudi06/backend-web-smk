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
     *     description="Retrieve all PTK",
     *     operationId="getAllPTK",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/PTKResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = tb_ptk::get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => PTKResource::collection($data),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataPTK = new tb_ptk();
        $dataPTK = tb_ptk::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Sukses menambahkan data',
            'data' => $dataPTK,
        ],200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile/teachers/{id}",
     *     tags={"PTK"},
     *     summary="Get specific PTK",
     *     description="Retrieve a specific PTK by its ID",
     *     operationId="getPTKById",
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
     *             @OA\Property(property="data", ref="#/components/schemas/PTKResource")
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
        $ptk = tb_ptk::find($id);

        if (!$ptk) {
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

        if (!$ptk) {
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

        if (!$ptk) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    
        $ptk->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
