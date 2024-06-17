<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FasilitasResource;
use App\Models\tb_facilities;
use App\Models\tb_prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FasilitasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/profile/facilities",
     *     tags={"Facilities"},
     *     summary="Get all facilities",
     *     description="Retrieve all facilities",
     *     operationId="getAllFacilities",
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data ditemukan"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/FasilitasResource")
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
        $data = tb_facilities::with('prodis')->get();

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => FasilitasResource::collection($data),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prodi = tb_prodi::where('prodi_name', $request->input('id_prodi'))->first();

        $validator = Validator::make($request->all(), [
            'facility_name' => 'required',
            'id_prodi' => 'required',
            'facility_text' => 'required',
            'facility_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'facility_name.required' => 'Kolom nama fasilitas harus diisi.',
            'id_prodi.required' => 'Kolom kategori fasilitas harus diisi.',
            'facility_text.required' => 'Kolom isi fasilitas harus diisi.',
            'facility_image.required' => 'Kolom gambar wajib diisi',
            'facility_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Simpan data ke tabel facility
        $data = new tb_facilities();
        $data->facility_name = $request->facility_name;
        $data->id_prodi = $request->id_prodi;
        $data->facility_text = $request->facility_text;

        // Simpan gambar
        if ($request->hasFile('facility_image')) {
            $fileContents = file_get_contents($request->file('facility_image')->getRealPath());
            $imageName = hash('sha256', $fileContents) . '.' . $request->file('facility_image')->getClientOriginalExtension();
            $request->file('facility_image')->move('img/fasilitas/', $imageName);
            $data->facility_image = $imageName;
        }

        $data->save();

        // Berikan respons berhasil dengan data fasilitas yang baru saja dibuat
        return response()->json([
            'message' => 'Fasilitas baru berhasil ditambahkan.',
            'data' => new FasilitasResource($data),
        ], 201);
    }


    /**
     * @OA\Get(
     *     path="/api/user/profile/facilities/{id}",
     *     tags={"Facilities"},
     *     summary="Get specific facility",
     *     description="Retrieve a specific facility by its ID",
     *     operationId="getFacilityById",
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
     *             @OA\Property(property="data", ref="#/components/schemas/FasilitasResource")
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
        $data = tb_facilities::with('prodis')
        ->where('id_facility', $id)
        ->first();

        if (empty($data)) {
            return response()->json([
                'data' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => new FasilitasResource($data),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari data fasilitas berdasarkan ID
        $data = tb_facilities::find($id);

        // Jika data tidak ditemukan, kembalikan pesan kesalahan
        if (!$data) {
            return response()->json(['errors' => 'Data fasilitas tidak ditemukan'], 404);
        }

        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'facility_name' => 'required',
            'id_prodi' => 'required',
            'facility_text' => 'required',
            'facility_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'facility_name.required' => 'Kolom nama fasilitas harus diisi.',
            'id_prodi.required' => 'Kolom kategori fasilitas harus diisi.',
            'facility_text.required' => 'Kolom isi fasilitas harus diisi.',
            'facility_image.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Perbarui data fasilitas dengan data yang baru
        $data->facility_name = $request->input('facility_name');
        $data->id_prodi = $request->input('id_prodi');
        $data->facility_text = $request->input('facility_text');

        // Jika ada file gambar yang diunggah, simpan gambar baru
        if ($request->hasFile('facility_image')) {
            $fileContents = file_get_contents($request->file('facility_image')->getRealPath());
            $imageName = hash('sha256', $fileContents) . '.' . $request->file('facility_image')->getClientOriginalExtension();
            $request->file('facility_image')->move('img/fasilitas/', $imageName);
            $data->facility_image = $imageName;
        }

        // Simpan perubahan
        $data->save();

        // Berikan respons berhasil dengan data fasilitas yang baru saja diperbarui
        return response()->json([
            'message' => 'Data fasilitas berhasil diperbarui.',
            'data' => new FasilitasResource($data),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facilities = tb_facilities::find($id);

        if (!$facilities) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $facilities->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
