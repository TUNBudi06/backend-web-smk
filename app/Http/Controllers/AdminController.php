<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.page.dashboard', [
            'menu_active' => 'dashboard',
        ]);
    }

    public function pengumuman()
    {
        return view('admin.page.pengumuman', [
            'menu_active' => 'pengumuman',
        ]);
    }

    public function agenda()
    {
        return view('admin.page.agenda', [
            'menu_active' => 'agenda',
        ]);
    }

    public function berita()
    {
        return view('admin.page.berita', [
            'menu_active' => 'berita',
        ]);
    }

    public function artikel()
    {
        return view('admin.page.artikel', [
            'menu_active' => 'artikel',
        ]);
    }

    public function gallery()
    {
        return view('admin.page.gallery', [
            'menu_active' => 'gallery',
        ]);
    }

    public function jurusan()
    {
        return view('admin.page.profile.jurusan', [
            'menu_active' => 'profile',
            'profile_active' => 'jurusan',
        ]);
    }

    public function extra()
    {
        return view('admin.page.profile.extra', [
            'menu_active' => 'profile',
            'profile_active' => 'extra',
        ]);
    }

    public function fasilitas()
    {
        return view('admin.page.profile.fasilitas', [
            'menu_active' => 'profile',
            'profile_active' => 'fasilitas',
        ]);
    }

    public function kemitraan()
    {
        return view('admin.page.profile.kemitraan', [
            'menu_active' => 'profile',
            'profile_active' => 'kemitraan',
        ]);
    }

    public function pd()
    {
        return view('admin.page.profile.pd', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
        ]);
    }

    public function ptk()
    {
        return view('admin.page.profile.ptk', [
            'menu_active' => 'profile',
            'profile_active' => 'ptk',
        ]);
    }

    public function links()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        return view('admin.page.links', [
            'menu_active' => 'links',
            'action' => $action,
        ]);
    }
}
