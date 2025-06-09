<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\tb_navbar;
use App\Models\tb_sub_navbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;

class NavbarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $token = $request->session()->get('token') ?? $request->input('token');
        $navbar = tb_navbar::get();
        [$navbar, $count] = Concurrency::run([
            fn () => Cache::flexible('navbar', [2, 20], function () use ($perPage) {
                return tb_navbar::orderBy('created_at', 'asc')
                    ->paginate($perPage);
            }),
            fn () => DB::table('tb_navbars')
                ->count(),
        ]);

        return view('admin.page.url.navbar.index', [
            'menu_active' => 'links',
            'navlink_active' => 'navbar',
            'navbar' => $navbar,
            'token' => $token,
            'dataCount' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.url.navbar.create', [
            'menu_active' => 'links',
            'info_active' => 'navbar',
            'navbar' => tb_navbar::all(),
            'token' => $token,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Nama Navbar harus diisi.',
        ]);

        $lastNavbarOrder = tb_navbar::max('order') ?? 0;

        $navbar = new tb_navbar;
        $navbar->title = $request->input('title');
        $navbar->route = $request->input('route');
        $navbar->is_dropdown = $request->input('is_dropdown');
        $navbar->order = $lastNavbarOrder + 1;
        $navbar->save();

        if ($request->has('sub_navbars') && is_array($request->sub_navbars)) {
            $order = 1;

            foreach ($request->sub_navbars as $sub) {
                tb_sub_navbar::create([
                    'navbar_id' => $navbar->id,
                    'title' => $sub['title'],
                    'route' => $sub['route'],
                    'description' => $sub['description'],
                    'icon' => $sub['icon'],
                    'order' => $order++,
                ]);
            }
        }

        return redirect()->route('navbar.index', ['token' => $token])->with('success', 'Navbar baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_navbar = $request->route('navbar');
        $token = $request->session()->get('token') ?? $request->input('token');
        $navbar = tb_navbar::findOrFail($id_navbar);
        $sub_navbar = tb_sub_navbar::where('navbar_id', $id_navbar)->get();

        return view('admin.page.url.navbar.show', [
            'menu_active' => 'links',
            'info_active' => 'navbar',
            'navbar' => $navbar,
            'sub_navbar' => $sub_navbar,
            'token' => $token,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_navbar = $request->route('navbar');
        $token = $request->session()->get('token') ?? $request->input('token');
        $navbar = tb_navbar::findOrFail($id_navbar);
        $sub_navbar = tb_sub_navbar::where('navbar_id', $id_navbar)->get();

        return view('admin.page.url.navbar.edit', [
            'menu_active' => 'links',
            'info_active' => 'navbar',
            'navbar' => $navbar,
            'sub_navbar' => $sub_navbar,
            'token' => $token,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id_navbar = $request->route('navbar');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Nama navbar harus diisi.',
        ]);

        $navbar = tb_navbar::findOrFail($id_navbar);

        $oldIsDropdown = $navbar->is_dropdown;

        $navbar->title = $request->input('title');
        $navbar->route = $request->input('route');
        $navbar->is_dropdown = $request->input('is_dropdown');
        $navbar->save();

        if ($oldIsDropdown == 1 && $request->input('is_dropdown') == 0) {
            tb_sub_navbar::where('navbar_id', $navbar->id)->delete();
        }

        if ($request->input('is_dropdown') == 1 && $request->has('sub_navbars') && is_array($request->sub_navbars)) {
            tb_sub_navbar::where('navbar_id', $navbar->id)->delete();

            $order = 1;
            foreach ($request->sub_navbars as $sub) {
                tb_sub_navbar::create([
                    'navbar_id' => $navbar->id,
                    'title' => $sub['title'],
                    'route' => $sub['route'],
                    'description' => $sub['description'],
                    'icon' => $sub['icon'],
                    'order' => $order++,
                ]);
            }
        }

        return redirect()->route('navbar.index', ['token' => $token])->with('success', 'Navbar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_navbar = $request->route('navbar');
        $token = $request->session()->get('token') ?? $request->input('token');

        $navbar = tb_navbar::findOrFail($id_navbar);

        if ($navbar->is_dropdown == 1) {
            tb_sub_navbar::where('navbar_id', $navbar->id)->delete();
        }

        $navbar->delete();

        return redirect()->route('navbar.index', ['token' => $token])->with('success', 'Navbar atau Sub Navbar berhasil dihapus.');
    }
}
