<?php

namespace App\Http\Controllers\api;

use App\Models\tb_admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Sek durung kegawe controller iki bud

    public function addToken(request $request)
    {
        $token = $request->validate([
            "token" => "required"
        ])["token"];

        $result = DB::table('tb_admin')->where('token', $token)->first();
        if ($result !== null) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memasukkan token',
                'data' => $token,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Proses memasukkan token gagal',
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'name' => 'required',
            'password' => 'required',
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses login gagal',
                'data' => $validator->errors()
            ], 401);
        }
    
        $admin = tb_admin::where('name', $request->name)->first();
        $admin = tb_admin::where('password', $request->password)->first();
    
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Name dan Password salah'
            ], 401);
        }
    
        $token = $admin->createToken('admin-token');
    
        return response()->json([
            'status' => true,
            'message' => 'Berhasil login',
            'data' => $admin,
        ]);
    }
}
