<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_elearning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;

class ElearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = request()->input('show') ?? 10;
        $elearning = tb_elearning::get();
        [$elearning, $count] = Concurrency::run([
            fn () => Cache::flexible('elearning', [2, 20], function () use ($perPage) {
                return tb_elearning::orderBy('created_at', 'asc')
                    ->paginate($perPage);
            }),
            fn () => DB::table('tb_navbars')
                ->count(),
        ]);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.elearning.index', [
            'menu_active' => 'academic',
            'profile_active' => 'elearning',
            'elearning' => $elearning,
            'dataCount' => $count,
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
