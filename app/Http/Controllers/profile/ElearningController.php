<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_badge;
use App\Models\tb_elearning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;

class ElearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = request()->input('show') ?? 10;
        $elearning = tb_elearning::get();
        [$elearning, $count] = Concurrency::run([
            fn () => Cache::flexible('elearning', [2, 20], function () use ($perPage) {
                return tb_elearning::orderBy('created_at', 'asc')
                    ->paginate($perPage);
            }),
            fn () => DB::table('tb_navbars')
                ->count(),
        ]);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.elearning.index', [
            'menu_active' => 'academic',
            'profile_active' => 'elearning',
            'elearning' => $elearning,
            'dataCount' => $count,
            'token' => $token,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $id_elearning = $request->route('elearning');
        $token = $request->session()->get('token') ?? $request->input('token');
        $elearning = tb_elearning::findOrFail($id_elearning);
        $badges = tb_badge::where('elearning_id', $id_elearning)->get();

        return view('admin.page.profile.elearning.edit', [
            'menu_active' => 'academic',
            'info_active' => 'elearning',
            'elearning' => $elearning,
            'badges' => $badges,
            'token' => $token,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_elearning = $request->route('elearning');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'id_badge' => 'required|array',
            'btn_label' => 'required',
            'btn_url' => 'required',
            'subtitle' => 'required',
            'body_desc' => 'required',
            'body_url' => 'required',
            'btn_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'title.required' => 'Kolom judul harus diisi.',
            'desc.required' => 'Kolom deskripsi utama harus diisi.',
            'id_badge.required' => 'Kolom badge harus diisi.',
            'btn_label.required' => 'Kolom label tombol harus diisi.',
            'btn_url.required' => 'Kolom url tombol harus diisi.',
            'subtitle.required' => 'Kolom subjudul harus diisi.',
            'body_desc.required' => 'Kolom deskripsi konten harus diisi.',
            'body_url.required' => 'Kolom url konten harus diisi.',
            'btn_icon.max' => 'Ukuran tombol ikon tidak boleh lebih dari 10MB.',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        $data = tb_elearning::findOrFail($id_elearning);

        $updateData = [
            'title' => $request->title,
            'desc' => $request->desc,
            'btn_label' => $request->btn_label,
            'btn_url' => $request->btn_url,
            'subtitle' => $request->subtitle,
            'body_desc' => $request->body_desc,
            'body_url' => $request->body_url,
        ];

        if ($request->hasFile('thumbnail')) {
            $updateData['thumbnail'] = $this->handleFileUpload($request, 'thumbnail', 'img/e-learning', $data->thumbnail);
        }

        if ($request->hasFile('btn_icon')) {
            $updateData['btn_icon'] = $this->handleFileUpload($request, 'btn_icon', 'img/badge', $data->btn_icon);
        }

        $data->update($updateData);

        $selectedBadges = $request->input('id_badge');

        DB::table('tb_badge')
            ->where('id_elearning', $id_elearning)
            ->whereNotIn('id', $selectedBadges)
            ->update(['id_elearning' => 0]);

        DB::table('tb_badge')
            ->whereIn('id', $selectedBadges)
            ->update(['id_elearning' => $id_elearning]);

        return redirect()->route('elearning.index', ['token' => $token])->with('success', 'E-Learning berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function handleFileUpload(Request $request, string $field, string $folder, ?string $oldFileName = null): string
    {
        if ($request->hasFile($field)) {
            if (! empty($oldFileName)) {
                $oldPath = public_path("$folder/$oldFileName");
                if (file_exists($oldPath) && ! is_dir($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $request->file($field)->hashName();
            $request->file($field)->move(public_path($folder), $newName);
            return $newName;
        }

        return $oldFileName;
    }
}
