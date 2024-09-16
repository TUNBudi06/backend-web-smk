<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_other;
use Illuminate\Http\Request;

class otherController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $other = tb_other::whereBetween('id_link', [4, 7])->get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.lainnya', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'action' => $action,
            'other' => $other,
            'token' => $token,
        ]);
    }

    public function show(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $data = tb_other::findOrFail($idData);

        return view('admin.page.url.lain.show', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'token' => $token,
            'data' => $data,
        ]);
    }

    public function editOther(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');

        return view('admin.page.url.lain.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'other',
            'token' => $token,
            'idData' => $idData,
        ]);
    }

    public function updateOther()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
