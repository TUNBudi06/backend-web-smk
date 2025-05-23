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
        dd($request);
        $id_elearning = $request->route('elearning');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'id_badge' => 'required',
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
            'btn_icon' => 'Kolom tombol ikon wajib diisi',
            'btn_icon.max' => 'Ukuran tombol ikon tidak boleh lebih dari 10MB.',
            'thumbnail' => 'Kolom gambar wajib diisi',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
