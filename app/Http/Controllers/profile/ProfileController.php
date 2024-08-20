<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function indexStruktur(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.struktur', [
            'menu_active' => 'profile',
            'profile_active' => 'struktur',
            'token' => $token,
        ]);
    }
}
