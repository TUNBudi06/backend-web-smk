<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_komite;
use Illuminate\Http\Request;

class KomiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $komite = tb_komite::get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.komite', [
            'menu_active' => 'profile',
            'action' => $action,
            'komite' => $komite,
            'token' => $token,
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
