<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tb_category_artikel;

class ArtikelCategory extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $artikel = tb_category_artikel::all();
        $action = $_GET['action'] ?? '';
//        return $request->session()->all();

        return view('admin.categories.beritacategory.index', [
            'menu_active' => 'berita',
            'action' => $action,
            'artikel' => $artikel,
            'token' => $token,
            "category" => $request->session()->get("category") ?? null,
            "action" => $request->session()->get("update") ?? false,
        ]);
    }
}
