<?php

namespace App\Http\Controllers;

use App\Models\tb_extra;
use App\Models\tb_facilities;
use App\Models\tb_gallery;
use App\Models\tb_jurusan;
use App\Models\tb_pemberitahuan;
use App\Models\tb_peserta_didik;
use App\Models\tb_ptk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $perpage = $request->input('show') ?? 10;

        [$artikel,$pengumuman,$berita,$event,$gallery,$fasilitas,$pd,$ptk,$extra,$jurusan,$log_pending] = Cache::flexible('HomeAdmin', [10, 20], function () {
            return Concurrency::run([
                fn () => tb_pemberitahuan::where('type', 1)->count(),
                fn () => tb_pemberitahuan::where('type', 2)->count(),
                fn () => tb_pemberitahuan::where('type', 3)->count(),
                fn () => tb_pemberitahuan::where('type', 4)->count(),
                fn () => tb_gallery::count(),
                fn () => tb_facilities::count(),
                fn () => tb_peserta_didik::count(),
                fn () => tb_ptk::count(),
                fn () => tb_extra::count(),
                fn () => tb_jurusan::count(),
                fn () => tb_pemberitahuan::where('approved', 0)->count(),
            ]);
        });

        $data_pending = tb_pemberitahuan::with('kategori')->with('tipe')->where('approved', 0)->paginate($perpage);

        return view('admin.page.dashboard', [
            'menu_active' => 'dashboard',
            'token' => $token,
            'artikel' => $artikel,
            'pengumuman' => $pengumuman,
            'berita' => $berita,
            'event' => $event,
            'gallery' => $gallery,
            'fasilitas' => $fasilitas,
            'pd' => $pd,
            'ptk' => $ptk,
            'extra' => $extra,
            'jurusan' => $jurusan,
            'log_pending' => $log_pending,
            'data_pending' => $data_pending,
        ]);
    }

    public function agenda(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.agenda', [
            'menu_active' => 'agenda',
            'token' => $token,
        ]);
    }

    public function artikel(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.artikel', [
            'menu_active' => 'artikel',
            'token' => $token,
        ]);
    }

    public function gallery(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.gallery', [
            'menu_active' => 'gallery',
            'token' => $token,
        ]);
    }

    public function extra(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.extra', [
            'menu_active' => 'profile',
            'profile_active' => 'extra',
            'token' => $token,
        ]);
    }

    public function fasilitas(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.fasilitas', [
            'menu_active' => 'profile',
            'profile_active' => 'fasilitas',
            'token' => $token,
        ]);
    }

    public function kemitraan(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.kemitraan', [
            'menu_active' => 'profile',
            'profile_active' => 'kemitraan',
            'token' => $token,
        ]);
    }

    public function pd(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.peserta_didik.index', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
            'token' => $token,
        ]);
    }

    public function links(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        return view('admin.page.links', [
            'menu_active' => 'links',
            'action' => $action,
            'token' => $token,
        ]);
    }

    public function error()
    {
        return view('layouts.error', [
            'menu_active' => '',
        ]);
    }
}
