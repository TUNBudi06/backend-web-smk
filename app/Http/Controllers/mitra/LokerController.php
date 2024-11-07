<?php

namespace App\Http\Controllers\mitra;

use App\Http\Controllers\Controller;
use App\Models\tb_kemitraan;
use App\Models\tb_loker;
use App\Models\tb_position;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $loker = tb_loker::with(['position', 'kemitraan'])->orderBy('created_at', 'desc')->paginate($perPage);
        $count = $loker->count();

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.loker.index', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'loker',
            'token' => $token,
            'loker' => $loker,
            'count' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $positions = tb_position::all();
        $kemitraans = tb_kemitraan::all();

        return view('admin.loker.create', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'loker',
            'token' => $token,
            'positions' => $positions,
            'kemitraans' => $kemitraans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'loker_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'loker_description' => 'required',
            'loker_for' => 'required',
            'position_id' => 'required|exists:tb_positions,id_position',
            'kemitraan_id' => 'required|exists:tb_kemitraans,id_kemitraan',
            'loker_available' => 'required|boolean',
        ], [
            'loker_thumbnail.required' => 'Kolom gambar wajib diisi',
            'loker_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'position_id.exists' => 'Posisi tidak valid.',
            'kemitraan_id.exists' => 'Kemitraan tidak valid.',
        ]);

        $data = new tb_loker;
        $data->loker_description = $request->loker_description;
        $data->loker_for = $request->loker_for;
        $data->position_id = $request->position_id;
        $data->kemitraan_id = $request->kemitraan_id;
        $data->loker_available = $request->loker_available;

        if ($request->hasFile('loker_thumbnail')) {
            $fileContents = file_get_contents($request->file('loker_thumbnail')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('loker_thumbnail')->getClientOriginalExtension();
            $request->file('loker_thumbnail')->move(public_path('img/loker/'), $imageName);
            $data->loker_thumbnail = $imageName;
        }

        if ($request->hasFile('loker_pdf')) {
            $fileContents = file_get_contents($request->file('loker_pdf')->getRealPath());
            $pdfName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('loker_pdf')->getClientOriginalExtension();
            $request->file('loker_pdf')->move(public_path('pdf/loker/'), $pdfName);
            $data->loker_pdf = $pdfName;
        }

        $data->save();

        return redirect()->route('loker.index', ['token' => $token])->with('success', 'Lowongan kerja baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_loker = $request->route('loker');
        $token = $request->session()->get('token') ?? $request->input('token');
        $loker = tb_loker::with(['position', 'kemitraan'])->findOrFail($id_loker);

        return view('admin.loker.edit', [
            'menu_active' => 'kemitraan',
            'mitra_active' => 'loker',
            'token' => $token,
            'loker' => $loker,
            'positions' => tb_position::all(),
            'kemitraans' => tb_kemitraan::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_loker = $request->route('loker');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'loker_thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'loker_description' => 'required',
            'loker_for' => 'required',
            'position_id' => 'required|exists:tb_positions,id_position',
            'kemitraan_id' => 'required|exists:tb_kemitraans,id_kemitraan',
            'loker_available' => 'required',
            'loker_pdf' => 'nullable|file|mimes:pdf,png,jpeg,jpg|max:10240',
        ], [
            'loker_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'position_id.exists' => 'Posisi tidak valid.',
            'kemitraan_id.exists' => 'Kemitraan tidak valid.',
        ]);

        $data = tb_loker::findOrFail($id_loker);
        $data->loker_description = $request->loker_description;
        $data->loker_for = $request->loker_for;
        $data->position_id = $request->position_id;
        $data->kemitraan_id = $request->kemitraan_id;
        $data->loker_available = $request->loker_available;

        if ($request->hasFile('loker_thumbnail')) {
            if (! empty($data->loker_thumbnail)) {
                $oldPdfPath = public_path('img/loker/'.$data->loker_thumbnail);
                if (file_exists($oldPdfPath) && ! is_dir($oldPdfPath)) {
                    unlink($oldPdfPath);
                }
            }

            $fileContents = file_get_contents($request->file('loker_thumbnail')->getRealPath());
            $imageName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('loker_thumbnail')->getClientOriginalExtension();
            $request->file('loker_thumbnail')->move(public_path('img/loker/'), $imageName);
            $data->loker_thumbnail = $imageName;
        }

        if ($request->hasFile('loker_pdf')) {
            if (! empty($data->loker_pdf)) {
                $oldPdfPath = public_path('pdf/loker/'.$data->loker_pdf);
                if (file_exists($oldPdfPath) && ! is_dir($oldPdfPath)) {
                    unlink($oldPdfPath);
                }
            }

            $fileContents = file_get_contents($request->file('loker_pdf')->getRealPath());
            $pdfName = substr(hash('sha256', $fileContents), 0, 40).'.'.$request->file('loker_pdf')->getClientOriginalExtension();
            $request->file('loker_pdf')->move(public_path('pdf/loker/'), $pdfName);
            $data->loker_pdf = $pdfName;
        }

        $data->save();

        return redirect()->route('loker.index', ['token' => $token])->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_loker = $request->route('loker');
        $token = $request->session()->get('token') ?? $request->input('token');

        $loker = tb_loker::findOrFail($id_loker);

        if ($loker->loker_thumbnail && file_exists(public_path('img/loker/'.$loker->loker_thumbnail)) && is_file(public_path('img/loker/'.$loker->loker_thumbnail))) {
            unlink(public_path('img/loker/'.$loker->loker_thumbnail));
        }

        if ($loker->loker_pdf && file_exists(public_path('pdf/loker/'.$loker->loker_pdf)) && is_file(public_path('pdf/loker/'.$loker->loker_pdf))) {
            unlink(public_path('pdf/loker/'.$loker->loker_pdf));
        }

        $loker->delete();

        return redirect()->route('loker.index', ['token' => $token])->with('success', 'Lowongan kerja berhasil dihapus.');
    }
}
