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
            fn() => Cache::flexible('elearning', [2, 20], function () use ($perPage) {
                return tb_elearning::orderBy('created_at', 'asc')
                    ->paginate($perPage);
            }),
            fn() => DB::table('tb_navbars')
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
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $badges = tb_badge::get();

        return view('admin.page.profile.elearning.create', [
            'menu_active' => 'academic',
            'info_active' => 'elearning',
            'badges' => $badges,
            'token' => $token,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'id_badge' => 'required|array',
            'btn_label' => 'required',
            'btn_url' => 'required',
            'btn_label_2' => 'required',
            'btn_url_2' => 'required',
            'subtitle' => 'required',
            'body_desc' => 'required',
            'body_url' => 'required',
            'btn_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'btn_icon_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'body_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'title.required' => 'Kolom judul harus diisi.',
            'desc.required' => 'Kolom deskripsi utama harus diisi.',
            'id_badge.required' => 'Kolom badge harus diisi.',
            'btn_label.required' => 'Kolom label tombol harus diisi.',
            'btn_url.required' => 'Kolom url tombol harus diisi.',
            'btn_label_2.required' => 'Kolom label tombol harus diisi.',
            'btn_url_2.required' => 'Kolom url tombol harus diisi.',
            'subtitle.required' => 'Kolom subjudul harus diisi.',
            'body_desc.required' => 'Kolom deskripsi konten harus diisi.',
            'body_url.required' => 'Kolom url konten harus diisi.',
            'btn_icon.max' => 'Ukuran tombol ikon tidak boleh lebih dari 10MB.',
            'btn_icon_2.max' => 'Ukuran tombol ikon tidak boleh lebih dari 10MB.',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'body_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        $data = new tb_elearning;
        $data->title = $request->title;
        $data->desc = $request->desc;
        $data->btn_label = $request->btn_label;
        $data->btn_url = $request->btn_url;
        $data->btn_label_2 = $request->btn_label_2;
        $data->btn_url_2 = $request->btn_url_2;
        $data->subtitle = $request->subtitle;
        $data->body_desc = $request->body_desc;
        $data->body_url = $request->body_url;

        if ($request->hasFile('thumbnail')) {
            $data->thumbnail = $this->handleFileUpload($request, 'thumbnail', 'img/e-learning', $data->thumbnail);
        }
        if ($request->hasFile('body_thumbnail')) {
            $data->body_thumbnail = $this->handleFileUpload($request, 'body_thumbnail', 'img/e-learning', $data->body_thumbnail);
        }
        if ($request->hasFile('btn_icon')) {
            $data->btn_icon = $this->handleFileUpload($request, 'btn_icon', 'img/e-learning', $data->btn_icon);
        }
        if ($request->hasFile('btn_icon_2')) {
            $data->btn_icon_2 = $this->handleFileUpload($request, 'btn_icon_2', 'img/e-learning', $data->btn_icon_2);
        }

        $data->save();
        $data->badges()->sync($request->id_badge);

        return redirect()->route('elearning.index', ['token' => $token])->with('success', 'E-Learning berhasil dibuat.');
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
        $badges = tb_badge::get();

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
            'btn_label_2' => 'required',
            'btn_url_2' => 'required',
            'subtitle' => 'required',
            'body_desc' => 'required',
            'body_url' => 'required',
            'btn_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'btn_icon_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'body_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'title.required' => 'Kolom judul harus diisi.',
            'desc.required' => 'Kolom deskripsi utama harus diisi.',
            'id_badge.required' => 'Kolom badge harus diisi.',
            'btn_label.required' => 'Kolom label tombol harus diisi.',
            'btn_url.required' => 'Kolom url tombol harus diisi.',
            'btn_label_2.required' => 'Kolom label tombol harus diisi.',
            'btn_url_2.required' => 'Kolom url tombol harus diisi.',
            'subtitle.required' => 'Kolom subjudul harus diisi.',
            'body_desc.required' => 'Kolom deskripsi konten harus diisi.',
            'body_url.required' => 'Kolom url konten harus diisi.',
            'btn_icon.max' => 'Ukuran tombol ikon tidak boleh lebih dari 10MB.',
            'btn_icon_2.max' => 'Ukuran tombol ikon tidak boleh lebih dari 10MB.',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
            'body_thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);

        $data = tb_elearning::findOrFail($id_elearning);

        $updateData = [
            'title' => $request->title,
            'desc' => $request->desc,
            'btn_label' => $request->btn_label,
            'btn_url' => $request->btn_url,
            'btn_label_2' => $request->btn_label,
            'btn_url_2' => $request->btn_url,
            'subtitle' => $request->subtitle,
            'body_desc' => $request->body_desc,
            'body_url' => $request->body_url,
        ];

        if ($request->hasFile('thumbnail')) {
            $updateData['thumbnail'] = $this->handleFileUpload($request, 'thumbnail', 'img/e-learning', $data->thumbnail);
        }
        if ($request->hasFile('body_thumbnail')) {
            $updateData['body_thumbnail'] = $this->handleFileUpload($request, 'body_thumbnail', 'img/e-learning', $data->body_thumbnail);
        }
        if ($request->hasFile('btn_icon')) {
            $updateData['btn_icon'] = $this->handleFileUpload($request, 'btn_icon', 'img/e-learning', $data->btn_icon);
        }
        if ($request->hasFile('btn_icon_2')) {
            $updateData['btn_icon_2'] = $this->handleFileUpload($request, 'btn_icon_2', 'img/e-learning', $data->btn_icon_2);
        }

        $data->update($updateData);
        $data->badges()->sync($request->id_badge);

        return redirect()->route('elearning.index', ['token' => $token])->with('success', 'E-Learning berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_elearning = $request->route('elearning');
        $token = $request->session()->get('token') ?? $request->input('token');

        $elearning = tb_elearning::where('id', $id_elearning)->firstOrFail();

        $this->deleteElearningImages($elearning, [
            'thumbnail' => 'img/e-learning',
            'body_thumbnail' => 'img/e-learning',
            'btn_icon' => 'img/badge',
            'btn_icon_2' => 'img/badge',
        ]);

        $elearning->delete();

        return redirect()->route('elearning.index', ['token' => $token])->with('success', 'E-Learning berhasil dihapus');
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

            $originalName = $request->file($field)->getClientOriginalName();
            $timestamp = time();
            $safeName = preg_replace('/\s+/', '-', $originalName);
            $newName = $timestamp . '_' . $safeName;

            $request->file($field)->move(public_path($folder), $newName);

            return $newName;
        }

        return $oldFileName;
    }

    private function deleteElearningImages(tb_elearning $elearning, array $fieldsWithFolder)
    {
        foreach ($fieldsWithFolder as $field => $folder) {
            $fileName = $elearning->$field;
            if (!empty($fileName)) {
                $filePath = public_path("$folder/$fileName");
                if (file_exists($filePath) && !is_dir($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
}
