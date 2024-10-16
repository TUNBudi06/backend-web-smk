<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_other;
use Illuminate\Http\Request;

class otherController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $other = tb_other::whereBetween('id_link', [4, 8])->get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.lainnya', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'action' => $action,
            'other' => $other,
            'token' => $token,
        ]);
    }

    public function show(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $data = tb_other::findOrFail($idData);

        return view('admin.page.url.lain.show', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'token' => $token,
            'data' => $data,
        ]);
    }

    public function editOther(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $data = tb_other::findOrFail($idData);

        return view('admin.page.url.lain.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'token' => $token,
            'idData' => $idData,
            'data' => $data,
        ]);
    }

    public function updateOther(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $findData = tb_other::findOrFail($idData);

        if ($idData != 8) {
            $request->validate([
                'type' => 'required',
            ]);

            if ($request->type == 'url') {
                $request->validate([
                    'url' => 'required',
                ]);
                $findData->type = 'url';
                $findData->url = $request->url;
            }

            if ($request->type == 'text') {
                $request->validate([
                    'description' => 'required',
                ]);
                $findData->type = 'text';
                $findData->description = $request->description;
            }

            if ($request->type == 'file') {
                $request->validate([
                    'file' => 'required',
                ]);
                $findData->type = 'file';
                $findData->description = $request->file('file')->getClientOriginalName();
                if ($findData->file) {
                    $oldFile = explode('/', $findData->file);
                    $oldFile = end($oldFile);
                    if (file_exists(public_path('data-pdf/'.$oldFile))) {
                        unlink(public_path('data-pdf/'.$oldFile));
                    }
                }
                if ($request->hasFile('file')) {
                    $fileContents = file_get_contents($request->file('file')->getRealPath());
                    $imageName = hash('sha256', $fileContents).'.'.$request->file('file')->getClientOriginalExtension();
                    $request->file('file')->move('data-pdf', $imageName);
                    $findData->url = asset('data-pdf/'.$imageName);
                }
            }
        } elseif ($idData == 8) {
            $request->validate([
                'description' => 'required',
                'jurusan_thumbnail' => 'file|required|image|mimes:jpeg,png,jpg,gif|max:10240',
            ], [
                'jurusan_thumbnail' => 'Kolom gambar wajib diisi',
                'jurusan_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            ]);
            $findData->description = $request->description;

            if ($request->hasFile('jurusan_thumbnail')) {
                if ($findData->url !== null) {
                    $oldImagePath = public_path('img/kepsek/'.$findData->url);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Simpan gambar baru
                $imageName = $request->file('jurusan_thumbnail')->hashName();
                $request->file('jurusan_thumbnail')->move('img/kepsek/', $imageName);
                $findData->url = asset('img/kepsek/'.$imageName);
            }
        }

        $findData->save();

        return redirect()->route('lainnya.index', ['token' => $token])->with('update', 'Data berhasil diubah');
    }

    public function destroy(Request $request)
    {
        //
    }
}
