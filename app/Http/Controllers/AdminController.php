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
}
