<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryBerita(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        return view('admin.category.category_berita', [
            'menu_active' => 'berita',
            'action' => $action,
            'token' => $token,
        ]);
    }

    public function categoryArtikel()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        return view('admin.category.category_artikel', [
            'menu_active' => 'artikel',
            'action' => $action,
        ]);
    }

    public function categoryGallery()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        return view('admin.category.category_gallery', [
            'menu_active' => 'gallery',
            'action' => $action,
        ]);
    }
}
