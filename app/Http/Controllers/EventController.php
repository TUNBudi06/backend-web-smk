<?php

namespace App\Http\Controllers;

use App\Models\tb_pemberitahuan;
use App\Models\tb_pemberitahuan_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        [$event,$count] = \Concurrency::run([
            fn () => \Cache::flexible('event', [3, 20], function () use ($perPage) {
                return tb_pemberitahuan::where(['type' => 4])
                    ->with('kategori')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
            }),
            fn () => tb_pemberitahuan::where(['type' => 4])->count(),
        ]);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.agenda.index', [
            'menu_active' => 'informasi',
            'info_active' => 'event',
            'token' => $token,
            'event' => $event,
            'countEvent' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.agenda.create', [
            'menu_active' => 'informasi',
            'info_active' => 'event',
            'event' => tb_pemberitahuan_category::where(['type' => 4])->get(),
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
            'location' => 'required',
            'pdf_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama agenda harus diisi.',
            'id_pemberitahuan_category.required' => 'Kolom kategori agenda harus diisi.',
            'target.required' => 'Kolom tipe agenda harus diisi.',
            'text.required' => 'Kolom isi agenda harus diisi.',
            'date.required' => 'Kolom tanggal agenda harus diisi.',
            'date.date' => 'Kolom tanggal agenda harus dalam format tanggal yang benar.',
            'location.required' => 'Kolom lokasi agenda harus diisi.',
        ]);

        $event = new tb_pemberitahuan;
        $event->nama = $request->nama;
        $event->category = $request->id_pemberitahuan_category;
        $event->target = $request->target;
        $event->text = $request->text;
        $event->date = $request->date;
        $event->location = $request->location;
        $event->approved = $request->session()->get('user')->role == 1 ? 1 : 0;
        $event->published_by = Auth::guard('admin')->id();
        $event->type = 4;
        $event->viewer = 0;

        if ($request->hasFile('thumbnail')) {
            $fileContents = file_get_contents($request->file('thumbnail')->getRealPath());
            $imageName = hash('sha256', $fileContents).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move('img/event', $imageName);
            $event->thumbnail = $imageName;
        } else {
            $event->thumbnail = 'img/no_image.png';
        }

        if ($request->hasFile('pdf_file')) {
            $fileContents = file_get_contents($request->file('pdf_file')->getRealPath());
            $pdfName = hash('sha256', $fileContents).'.'.$request->file('pdf_file')->getClientOriginalExtension();
            $request->file('pdf_file')->move('pdf/event', $pdfName);
            $event->pdf = $pdfName;
        } else {
            $event->pdf = 'img/no_image.png';
        }

        $event->save();

        return redirect()->route('event.index', ['token' => $token])->with('success', 'Agenda baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_event = $request->route('event');
        $token = $request->session()->get('token') ?? $request->input('token');
        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);
        // dd($event);

        return view('admin.agenda.show', [
            'menu_active' => 'informasi',
            'info_active' => 'event',
            'token' => $token,
            'event' => $event,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_event = $request->route('event');
        $token = $request->session()->get('token') ?? $request->input('token');
        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);
        $categories = tb_pemberitahuan_category::where(['type' => 4])->get();

        return view('admin.agenda.edit', [
            'menu_active' => 'informasi',
            'info_active' => 'event',
            'token' => $token,
            'event' => $event,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_event = $request->route('event');
        $request->validate([
            'nama' => 'required',
            'target' => 'required',
            'text' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pdf_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:10240',
        ], [
            'nama.required' => 'Kolom nama agenda harus diisi.',
            'target.required' => 'Kolom tipe agenda harus diisi.',
            'text.required' => 'Kolom isi agenda harus diisi.',
            'date.required' => 'Kolom tanggal agenda harus diisi.',
            'date.date' => 'Kolom tanggal agenda harus dalam format tanggal yang benar.',
            'location.required' => 'Kolom lokasi agenda harus diisi.',
            'thumbnail.required' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);

        if ($request->hasFile('thumbnail')) {
            // Hapus gambar sebelumnya jika ada
            if (! empty($event->thumbnail)) {
                $oldImagePath = public_path('img/event/'.$event->thumbnail);
                if (file_exists($oldImagePath) && ! is_dir($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('thumbnail')->hashName();
            $request->file('thumbnail')->move('img/event', $imageName);
            $event->thumbnail = $imageName;
        }

        if ($request->hasFile('pdf_file')) {
            // Hapus gambar sebelumnya jika ada
            if (! empty($event->pdf)) {
                $oldPdfPath = public_path('pdf/event/'.$event->pdf);
                if (file_exists($oldPdfPath) && ! is_dir($oldPdfPath)) {
                    unlink($oldPdfPath);
                }
            }

            // Simpan gambar baru
            $pdfName = $request->file('pdf_file')->hashName();
            $request->file('pdf_file')->move('pdf/event', $pdfName);
            $event->pdf = $pdfName;
        }

        $event->update([
            'nama' => $request->nama,
            'target' => $request->target,
            'category' => $request->id_pemberitahuan_category,
            'text' => $request->text,
            'date' => $request->date,
            'location' => $request->location,
        ]);

        return redirect()->route('event.index', ['token' => $request->token])->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_event = $request->route('event');
        $token = $request->session()->get('token') ?? $request->input('token');

        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);

        $imagePath = public_path('img/event/'.$event->thumbnail);
        $pdfPath = public_path('pdf/event/'.$event->pdf);

        $event->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        return redirect()->route('event.index', ['token' => $request->token])->with('success', 'Agenda berhasil dihapus.');
    }
}
