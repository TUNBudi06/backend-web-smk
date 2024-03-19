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
}
