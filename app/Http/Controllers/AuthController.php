<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function tokenPage()
    {
        return view('admin.guest.token');
    }

    public function loginPage()
    {
        return view('admin.guest.login');
    }
}
