<?php

namespace App\Http\Controllers;

use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use App\Models\tb_pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Concurrency;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        [$pengumuman,$count] = Concurrency::run([
            fn () => \Cache::flexible('pengumuman', [3, 20], function () use ($perPage) {
                return tb_pemberitahuan::where(['type' => 2])
                    ->with('kategori')
                    ->orderBy('date', 'desc')
                    ->paginate($perPage);
            }),
            fn () => tb_pemberitahuan::where(['type' => 2])->count(),
        ]);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.pengumuman.index', [
            'menu_active' => 'informasi',
            'info_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
            'countPengumuman' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.pengumuman.create', [
            'menu_active' => 'informasi',
            'info_active' => 'pengumuman',
            'pengumuman' => tb_pemberitahuan_category::where(['type' => 2])->get(),
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
            'nama' => 'required',
            'id_pemberitahuan_category' => 'required',
            'target' => 'required',
            'text' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pdf_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama pengumuman harus diisi.',
            'id_pemberitahuan_category.required' => 'Kolom kategori pengumuman harus diisi.',
            'target.required' => 'Kolom target pengumuman harus diisi.',
            'text.required' => 'Kolom isi pengumuman harus diisi.',
            'date.required' => 'Kolom tanggal pengumuman harus diisi.',
            'date.date' => 'Kolom tanggal pengumuman harus dalam format tanggal yang benar.',
            'time.required' => 'Kolom waktu pengumuman harus diisi.',
            'thumbnail.required' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        //        tb_pengumuman::create($request->all());
        $data = new tb_pemberitahuan;
        $data->nama = $request->nama;
        $data->category = $request->id_pemberitahuan_category;
        $data->target = $request->target;
        $data->text = $request->text;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->viewer = 0;
        $data->approved = $request->session()->get('user')->role == 1 ? 1 : 0;
        $data->published_by = Auth::guard('admin')->id();
        $data->type = 2;

        if ($request->hasFile('thumbnail')) {
            $fileContents = file_get_contents($request->file('thumbnail')->getRealPath());
            $imageName = hash('sha256', $fileContents).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move('img/announcement', $imageName);
            $data->thumbnail = $imageName;
        }

        if ($request->hasFile('pdf_file')) {
            $fileContents = file_get_contents($request->file('pdf_file')->getRealPath());
            $pdfName = hash('sha256', $fileContents).'.'.$request->file('pdf_file')->getClientOriginalExtension();
            $request->file('pdf_file')->move('pdf/announcement', $pdfName);
            $data->pdf = $pdfName;
        }

        $data->save();

        return redirect()->route('pengumuman.index', ['token' => $token])->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_pengumuman = $request->route('pengumuman');
        $token = $request->session()->get('token') ?? $request->input('token');
        $pengumuman = tb_pemberitahuan::where(['type' => 2])->findOrFail($id_pengumuman);

        return view('admin.pengumuman.show', [
            'menu_active' => 'informasi',
            'info_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_pengumuman = $request->route('pengumuman');
        $token = $request->session()->get('token') ?? $request->input('token');
        $pengumuman = tb_pemberitahuan::where(['type' => 2])->findOrFail($id_pengumuman);
        $categories = tb_pemberitahuan_category::where(['type' => 2])->get();

        return view('admin.pengumuman.edit', [
            'menu_active' => 'informasi',
            'info_active' => 'pengumuman',
            'token' => $token,
            'pengumuman' => $pengumuman,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_pengumuman = $request->route('pengumuman');
        $request->validate([
            'nama' => 'required',
            'target' => 'required',
            'text' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pdf_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama pengumuman harus diisi.',
            'target.required' => 'Kolom target pengumuman harus diisi.',
            'text.required' => 'Kolom isi pengumuman harus diisi.',
            'date.required' => 'Kolom tanggal pengumuman harus diisi.',
            'date.date' => 'Kolom tanggal pengumuman harus dalam format tanggal yang benar.',
            'time.required' => 'Kolom waktu pengumuman harus diisi.',
            'thumbnail.required' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        $data = tb_pemberitahuan::where('tb_pemberitahuan.type', 2)
            ->findOrFail($id_pengumuman);

        if ($request->hasFile('thumbnail')) {
            // Hapus gambar sebelumnya jika ada
            if (! empty($data->thumbnail)) {
                $oldImagePath = public_path('img/announcement/'.$data->thumbnail);
                if (file_exists($oldImagePath) && ! is_dir($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('thumbnail')->hashName();
            $request->file('thumbnail')->move('img/announcement', $imageName);
            $data->thumbnail = $imageName;
        }

        if ($request->hasFile('pdf_file')) {
            // Hapus file sebelumnya jika ada
            if (! empty($data->pdf)) {
                $oldPdfPath = public_path('pdf/announcement/'.$data->pdf);
                if (file_exists($oldPdfPath) && ! is_dir($oldPdfPath)) {
                    unlink($oldPdfPath);
                }
            }

            // Simpan file baru
            $pdfName = $request->file('pdf_file')->hashName();
            $request->file('pdf_file')->move('pdf/announcement', $pdfName);
            $data->pdf = $pdfName;
        }

        $data->update([
            'nama' => $request->nama,
            'target' => $request->target,
            'category' => $request->id_pemberitahuan_category,
            'date' => $request->date,
            'time' => $request->time,
            'text' => $request->text,
        ]);

        return redirect()->route('pengumuman.index', ['token' => $request->token])->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_pengumuman = $request->route('pengumuman');
        $token = $request->session()->get('token') ?? $request->input('token');

        $pengumuman = tb_pemberitahuan::where('id_pemberitahuan', $id_pengumuman)
            ->where('type', 2)
            ->firstOrFail();

        $imagePath = public_path('img/announcement/'.$pengumuman->thumbnail);
        $pdfPath = public_path('pdf/announcement/'.$pengumuman->pdf);

        $pengumuman->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        return redirect()->route('pengumuman.index', ['token' => $request->token])->with('success', 'Pengumuman berhasil dihapus.');

    }
}
