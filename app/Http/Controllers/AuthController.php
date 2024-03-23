<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function firstAuth($token)
    {
        if (session()->has('user')) {
            return redirect('dashboard');
        } else {
            $result = DB::table('tb_admin')->where('token', $token)->first();
            if ($result !== null) {
                $nToken = $token;
                return view('admin.login', ['token' => $token]);
            } else {
                return view('layouts.error');
            }
        }
    }

    public function tokenPage(Request $request)
    {
        $token = $request->input('token');
        $result = DB::table('tb_admin')->where('token', $token)->first();

        if ($result) {
            return redirect()->route('guest.login', ['token' => $token]);
        } else {
            return view('layouts.error');
        }
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
