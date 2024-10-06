<?php

namespace App\Http\Controllers;

use App\Models\tb_pemberitahuan;
use Illuminate\Http\Request;

class logUserAproved extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = tb_pemberitahuan::with('kategori')->with('tipe')->where('approved', 0)->get();

        return view('admin.page.management.LogApproved.index', [
            'menu_active' => 'user',
            'pending' => $data,
            'token' => $token,
        ]);
    }

    public function approve(Request $request, $token, $id)
    {
        $data = tb_pemberitahuan::findOrFail($id);
        $data->approved = 1;
        $data->Approved_by = $request->session()->get('user')->name;
        $data->save();

        return back()->with('success', 'Berhasil mengubah status');
    }

    public function deleted(Request $request, $token, $id)
    {
        $data = tb_pemberitahuan::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Berhasil menghapus status dan informasi');
    }
}
