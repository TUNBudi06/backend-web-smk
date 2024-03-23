<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function firstAuth(request $request)
    {
        $token = $request->validate([
            "token" => "required"
        ])["token"];
        if (session()->has('user')) {
            return redirect('dashboard');
        } else {
            $result = DB::table('tb_admin')->where('token', $token)->first();
            if ($result !== null) {
                $nToken = $token;
                return view('admin.guest.login', ['token' => $token]);
            } else {
                return view('layouts.error');
            }
        }
    }

    public function tokenPage(Request $request)
    {
        return view("admin.guest.token");
    }

    public function checkTokenUrl($token)
    {
        $result = DB::table('tb_admin')->where('token', $token)->first();
        return $result;
    }


    public function loginPage()
    {
        return view('admin.guest.login');
    }
}
