<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_other;
use Illuminate\Http\Request;

class otherController extends Controller
{
    public function index(Request $request) {
        $token = $request->session()->get('token') ?? $request->input('token');
        $other = tb_other::get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.lainnya',[
            'menu_active' => 'profile',
            'profile_active' => 'video',
            'action' => $action,
            'other' => $other,
            'token' => $token,
        ]);
    }
}
