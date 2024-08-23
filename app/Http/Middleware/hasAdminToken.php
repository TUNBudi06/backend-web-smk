<?php

namespace App\Http\Middleware;

use App\Models\tb_admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class hasAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        $admin = tb_admin::where('token', $token)->first();
        if ($admin) {
            return $next($request);
        }

        return abort(404, 'not Found');
    }
}
