<?php

namespace App\Http\Controllers;

use App\Models\tb_admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class profileAdmin extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $user = User::where("token",$token)->first();
        $user_role = $user->role();
        return view('admin.page.profile', [
            'menu_active' => 'profile',
            'token' => $token,
            "email" => $user["email"],
            "nama" => $user["name"],
            "username"=>$user["username"],
            "user_type" => $user_role->value("name")
        ]);
    }

    public function  updateAdmin(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate([
           "nama" => "required|min:4",
           "email" => "required|email",
        ]);

        $user = User::where("token",$token)->first();
        $user->update($data);

         if ($request->has("password") && $request->has("password_new")) {
             if(password_verify($request->get("password"),$user->password)){
                $hashedPassword = hash::make($request->get("password_new"));
                $user->password = $hashedPassword;
                $user->save();
             }
         }
         return redirect()->back();
    }

    public function  updateToken(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate([
            "token" => "required|min:4"
        ]);

        $user = User::where("token",$token)->first();
        $user->update($data);
        return redirect()->route("profile",$request->token);
    }
}
