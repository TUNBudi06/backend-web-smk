<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\BasicInformationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;

class BasicInformation extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show') ?? 10;
        [$basic, $count] = Concurrency::run([
            fn () => Cache::flexible('basic_' . request('page', 1) . '_show_' . $perPage, [2, 20], function () use ($perPage) {
                return BasicInformationModel::orderBy('id', 'desc')->paginate($perPage);
            }),
            fn () => DB::table('tb_basic-information')
                ->count(),
        ]);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.Basic.index', [
            'menu_active' => 'links',
            'navlink_active' => 'basic',
            'token' => $token,
            'basic' => $basic,
            'count' => $count,
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
    public function show(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $data = BasicInformationModel::findOrFail($idData);

        return view('admin.page.profile.Basic.edit', [
            'menu_active' => 'links',
            'profile_active' => 'other',
            'type' => 'show',
            'token' => $token,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $data = BasicInformationModel::findOrFail($idData);

        return view('admin.page.profile.Basic.edit', [
            'menu_active' => 'links',
            'profile_active' => 'other',
            'type' => 'edit',
            'token' => $token,
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $idData = $request->route('id');
        $findData = BasicInformationModel::findOrFail($idData);

        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            if ($findData->logo !== null && file_exists($findData->logo)) {
                unlink($findData->logo);
            }
            $fileContents = file_get_contents($request->file('logo')->getRealPath());
            $imageName = hash('sha256', $fileContents).'.'.$request->file('logo')->getClientOriginalExtension();
            $imagepath = $findData->path.$imageName;
            $request->file('logo')->move($findData->path, $imageName);
            $findData->logo = $imagepath;
        }

        $findData->alias_name = $request->alias_name;
        $findData->name = $request->name;
        $findData->url = $request->url;
        $findData->save();

        return redirect()->route('basic.index', ['token' => $token])->with('success', 'Basic Information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
