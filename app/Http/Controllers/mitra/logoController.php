<?php

namespace App\Http\Controllers\mitra;

use App\Http\Controllers\Controller;
use App\Models\tb_logo_mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class logoController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $perpage = $request->input('show', 10);

        $logok = tb_logo_mitra::paginate($perpage);

        return view('admin.logoKemitraan.index', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'logok',
            'token' => $token,
            'logoK' => $logok,
            'count' => $logok->count(),
        ]);

    }

    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.logoKemitraan.create', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'logok',
            'token' => $token,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'width_logo' => 'required|integer|min:1|max:140',
            'height_logo' => 'required|integer|min:1|max:140',
            'kemitraan_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('kemitraan_thumbnail')) {
            $fileContents = file_get_contents($request->file('kemitraan_thumbnail')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('kemitraan_thumbnail')->getClientOriginalExtension();
            $request->file('kemitraan_thumbnail')->move(public_path('img/mitra/'), $imageName);
            $filePath = $imageName;
        }

        $logo = new tb_logo_mitra;
        $logo->nama_mitra = $validatedData['nama_mitra'];
        $logo->width = $validatedData['width_logo'];
        $logo->height = $validatedData['height_logo'];
        $logo->logo_mitra = $filePath ?? 'img/no_image.png';
        $logo->save();

        return redirect()->route('logok.index', ['token' => $request->token])
            ->with('success', 'Logo Kemitraan berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $logo = tb_logo_mitra::findOrFail($request->route('id'));

        return view('admin.logoKemitraan.edit', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'logok',
            'token' => $token,
            'logo' => $logo,
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->route('id');

        $logo = tb_logo_mitra::findOrFail($id);

        // Validate the input data
        $validatedData = $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'width_logo' => 'required|integer|min:1|max:140',
            'height_logo' => 'required|integer|min:1|max:140',
            'kemitraan_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Check if a new file is uploaded and handle file update
        if ($request->hasFile('kemitraan_thumbnail')) {
            if ($logo->logo_mitra && file_exists(public_path('img/mitra/'.$logo->logo_mitra))) {
                unlink(public_path('img/mitra/'.$logo->logo_mitra));
            }

            $fileContents = file_get_contents($request->file('kemitraan_thumbnail')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('kemitraan_thumbnail')->getClientOriginalExtension();
            $request->file('kemitraan_thumbnail')->move(public_path('img/mitra/'), $imageName);
            $logo->logo_mitra = $imageName;
        }

        // Update the logo data with validated data
        $logo->nama_mitra = $validatedData['nama_mitra'];
        $logo->width = $validatedData['width_logo'];
        $logo->height = $validatedData['height_logo'];
        $logo->save();

        return redirect()->route('logok.index', ['token' => $request->token])
            ->with('success', 'Logo Kemitraan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $id_kemitraan = $request->idName;
        $token = $request->session()->get('token') ?? $request->input('token');

        $kemitraan = tb_logo_mitra::findOrFail($id_kemitraan);
        $kemitraan->delete();

        if (file_exists(public_path('img/mitra/'.$kemitraan->logo_mitra))) {
            unlink(public_path('img/mitra/'.$kemitraan->logo_mitra));
        }

        return redirect()->route('logok.index', ['token' => $token])->with('success', 'Logo Kemitraan berhasil dihapus.');
    }
}
