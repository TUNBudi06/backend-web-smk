<?php

namespace App\Http\Controllers;

use App\Models\tb_artikel;
use App\Models\tb_event;
use App\Models\tb_gallery;
use App\Models\tb_news;
use App\Models\tb_pengumuman;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');



        return view('admin.page.dashboard', [
            'menu_active' => 'dashboard',
            'token' => $token,
            "artikel"=> tb_artikel::count(),
            "berita"=>tb_news::count(),
            "event"=>tb_event::count(),
            "gallery"=>tb_gallery::count(),
            "pengumuman"=>tb_pengumuman::count(),
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

        return view('admin.page.profile.pd', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
            'token' => $token,
        ]);
    }

    public function ptk(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.ptk', [
            'menu_active' => 'profile',
            'profile_active' => 'ptk',
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
