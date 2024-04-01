<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_ptk;
use Illuminate\Http\Request;

class PTKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $ptk = tb_ptk::orderBy('id', 'asc')->paginate($perPage);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.ptk.index', [
            'menu_active' => 'profile',
            'profile_active' => 'ptk',
            'token' => $token,
            'ptk' => $ptk,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
