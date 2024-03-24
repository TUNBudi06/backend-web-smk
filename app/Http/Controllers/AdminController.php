<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.dashboard', [
            'menu_active' => 'dashboard',
            'token' => $token,
        ]);
    }

    // public function pengumuman(Request $request)
    // {
    //     $token = $request->session()->get('token') ?? $request->input('token');

    //     return view('admin.page.pengumuman', [
    //         'menu_active' => 'pengumuman',
    //         'token' => $token,
    //     ]);
    // }

    public function agenda(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.agenda', [
            'menu_active' => 'agenda',
            'token' => $token,
        ]);
    }

    public function berita(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.berita', [
            'menu_active' => 'berita',
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

    public function jurusan(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.jurusan', [
            'menu_active' => 'profile',
            'profile_active' => 'jurusan',
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

    public function profile(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.page.profile', [
            'menu_active' => 'profile',
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
