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
     * Display a listing of the resource.
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

        // if (!$prodi) {
        //     return response()->json(['errors' => 'Program studi tidak ditemukan'], 404);
        // }
        
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
        $data->facility_name = $request->input('facility_name');
        $data->id_prodi = $prodi->id_prodi;
        $data->facility_text = $request->input('facility_text');

        // Simpan gambar
        if ($request->hasFile('facility_image')) {
            $fileContents = file_get_contents($request->file('facility_image')->getRealPath());
            $imageName = hash('sha256', $fileContents) . '.' . $request->file('facility_image')->getClientOriginalExtension();
            $request->file('facility_image')->move('img/fasilitas/', $imageName);
            $data->facility_image = $imageName;
        }

        $data->save();

        return response()->json([
                'message' => 'Fasilitas baru berhasil ditambahkan.',
                'data' => FasilitasResource::collection($data),
            ],
            201
        );
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
