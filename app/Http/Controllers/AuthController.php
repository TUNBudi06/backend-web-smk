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
            return redirect()->route('dashboard');
        } else {
            $result = DB::table('tb_admin')->where('token', $token)->first();
            if ($result !== null) {
                $nToken = $token;
                return redirect()->route('guest.login', ['token' => $token]);
            } else {
                return back();
            }
        }
    }

    public function tokenPage()
    {
        return view('admin.guest.token');
    }

    public function checkTokenUrl($token)
    {
        $result = DB::table('tb_admin')->where('token', $token)->first();
        return $result;
    }

    public function getToken($token)
    {
        return $token;
    }

    public function loginPage($token)
    {
        return view('admin.guest.login', [
            'token' => $token,
        ]);
    }

    public function login(Request $request, $token)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $cookie = $request->has('cookie') ? true : false;

        $user = DB::table('tb_admin')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if ($user) {
            if (password_verify($password, $user->password)) {
                if ($cookie) {
                    // Set cookie, menggunakan helper 'cookie'
                    cookie()->queue('email', $email, 30 * 24 * 60); // Cookie berlaku selama 30 hari
                    cookie()->queue('password', $password, 30 * 24 * 60);
                }

                // Set session user
                $request->session()->put('user', $user);
                $request->session()->put('token', $token);
                $request->session()->put('status', 'benar');
                
                // Redirect ke dashboard
                return redirect()->route('dashboard', ['token' => $token]);
            } else {
                // Password tidak sesuai
                return back()->with('loginError', 'Login Failed. Email / Password Invalid');
            }
        } else {
            // User tidak ditemukan
            return back()->with('loginError', 'Login Failed. Email / Password Invalid');
        }
    }

    public function logout(Request $request)
    {
        session_destroy();
        $_SESSION = [];
        
        return redirect()->route('guest.token');
    }
}
