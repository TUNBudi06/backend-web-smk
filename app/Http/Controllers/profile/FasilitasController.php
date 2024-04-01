<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_facilities;
use App\Models\tb_prodi;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $fasilitas = tb_facilities::orderBy('id_facility', 'desc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.page.profile.fasilitas.index', [
            'menu_active' => 'profile',
            'profile_active' => 'fasilitas',
            'token' => $token,
            'fasilitas' => $fasilitas,
            'prodis' => tb_prodi::all(),
        ]);
    }
}
