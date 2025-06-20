<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\tb_badge;
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
        [$navbar, $count] = Concurrency::run([
            fn () => Cache::flexible('navbar_' . request('page', 1) . '_show_' . $perPage, [2, 20], function () use ($perPage) {
                return tb_navbar::orderBy('created_at', 'asc')->paginate($perPage);
            }),
            fn () => DB::table('tb_navbars')
                ->count(),
        ]);

        return view('admin.page.url.navbar.index', [
            'menu_active' => 'links',
            'navlink_active' => 'navbar',
            'navbar' => $navbar,
            'token' => $token,
            'count' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $badges = tb_badge::all();

        return view('admin.page.url.navbar.create', [
            'menu_active' => 'links',
            'info_active' => 'navbar',
            'navbar' => tb_navbar::all(),
            'badges' => $badges,
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

            foreach ($request->sub_navbars as $i => $sub) {
                $iconPath = null;

                if ($request->hasFile("sub_navbars.$i.icon")) {
                    $file = $request->file("sub_navbars.$i.icon");
                    $time = time();
                    $originalName = $file->getClientOriginalName();
                    $imageName = $time . '_' . $originalName;
                    $file->move(public_path('img/navbar'), $imageName);
                    $iconPath = $imageName;
                }

                tb_sub_navbar::create([
                    'navbar_id'  => $navbar->id,
                    'title'      => $sub['title'],
                    'route'      => $sub['route'],
                    'description'=> $sub['description'],
                    'icon'       => $iconPath,
                    'order'      => $order++,
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
        $badges = tb_badge::all();

        return view('admin.page.url.navbar.edit', [
            'menu_active' => 'links',
            'info_active' => 'navbar',
            'navbar' => $navbar,
            'sub_navbar' => $sub_navbar,
            'badges' => $badges,
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

        if ($request->has('deleted_sub_navbars')) {
            foreach ($request->deleted_sub_navbars as $id) {
                $subNavbar = tb_sub_navbar::find($id);
                if ($subNavbar) {
                    if ($subNavbar->icon && file_exists(public_path('img/navbar/' . $subNavbar->icon))) {
                        unlink(public_path('img/navbar/' . $subNavbar->icon));
                    }
                    $subNavbar->delete();
                }
            }
        }

        $order = 1;
        if ($request->has('sub_navbars')) {
            $existingIds = tb_sub_navbar::where('navbar_id', $navbar->id)->pluck('id')->toArray();

            $currentIds = collect($request->sub_navbars)
                ->pluck('id')
                ->filter()
                ->map(function ($id) {
                    return (int) $id;
                })
                ->toArray();

            $deletedIds = array_diff($existingIds, $currentIds);

            foreach ($deletedIds as $id) {
                $sub = tb_sub_navbar::find($id);
                if ($sub) {
                    if ($sub->icon && file_exists(public_path('img/navbar/' . $sub->icon))) {
                        unlink(public_path('img/navbar/' . $sub->icon));
                    }
                    $sub->delete();
                }
            }

            foreach ($request->sub_navbars as $i => $sub) {
                $data = [
                    'navbar_id'   => $navbar->id,
                    'title'       => $sub['title'],
                    'route'       => $sub['route'],
                    'description' => $sub['description'],
                    'order'       => $order++,
                ];

                if (!empty($sub['id'])) {
                    $subNavbar = tb_sub_navbar::find($sub['id']);
                    if (!$subNavbar) {
                        continue;
                    }

                    if ($request->hasFile("sub_navbars.$i.icon")) {
                        if ($subNavbar->icon && file_exists(public_path('img/navbar/' . $subNavbar->icon))) {
                            unlink(public_path('img/navbar/' . $subNavbar->icon));
                        }

                        $file = $request->file("sub_navbars.$i.icon");
                        $time = time();
                        $originalName = $file->getClientOriginalName();
                        $iconName = $time . '_' . $originalName;
                        $file->move(public_path('img/navbar'), $iconName);

                        $data['icon'] = $iconName;
                    } else {
                        $data['icon'] = $subNavbar->icon;
                    }

                    $subNavbar->update($data);
                }
                else {
                    if ($request->hasFile("sub_navbars.$i.icon")) {
                        $file = $request->file("sub_navbars.$i.icon");
                        $time = time();
                        $originalName = $file->getClientOriginalName();
                        $iconName = $time . '_' . $originalName;
                        $file->move(public_path('img/navbar'), $iconName);

                        $data['icon'] = $iconName;
                    } else {
                        $data['icon'] = null;
                    }

                    tb_sub_navbar::create($data);
                }
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
            $subNavbars = tb_sub_navbar::where('navbar_id', $navbar->id)->get();

            foreach ($subNavbars as $sub) {
                if ($sub->icon && file_exists(public_path('img/navbar/' . $sub->icon))) {
                    unlink(public_path('img/navbar/' . $sub->icon));
                }
            }

            tb_sub_navbar::where('navbar_id', $navbar->id)->delete();
        }
        $navbar->delete();

        return redirect()->route('navbar.index', ['token' => $token])->with('success', 'Navbar atau Sub Navbar berhasil dihapus.');
    }
}
