<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
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
