<?php

namespace App\Http\Middleware\auth;

use App\Models\tb_admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class adminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = session('user') ?? null;
        $token = $request->route('token');
        $rToken = $request->session()->get('token') ?? $request->input('token');
//        Log::info($request->session()->get('token').' | '.$request->input('token'));
//        Log::info($email);
        if ($rToken != $token) {
            return redirect()->route('guest.token');
        }
        $user = tb_admin::where('token', $token)
            ->first();
        if (! $email == null) {
            if ($email->email != $user->email) {
                return redirect()->route('guest.token');
            }
        }
        if (session('status') != 'true') {
            return redirect()->route('guest.token');
        }
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        return redirect()->route('guest.token');
    }
}
