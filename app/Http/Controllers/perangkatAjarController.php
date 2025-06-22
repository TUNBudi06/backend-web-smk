<?php

namespace App\Http\Controllers;

use App\Models\tb_perangkatAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;

class perangkatAjarController extends Controller
{
    public function indexTools(Request $request)
    {
        $perPage = $request->input('show', 10);
        $page = $request->input('page', 1);

        $pa = Cache::flexible("pa_{$page}_show_{$perPage}", [3, 20], function () use ($perPage) {
            return tb_perangkatAjar::paginate($perPage);
        });
        $count = Cache::flexible("pa_count", [3, 20], fn () => tb_perangkatAjar::count());

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.perangkatAjar.index', [
            'menu_active' => 'academic',
            'profile_active' => 'tools',
            'token' => $token,
            'pa' => $pa,
            'count' => $count,
        ]);
    }

    public function createTools(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.perangkatAjar.create', [
            'menu_active' => 'academic',
            'profile_active' => 'tools',
            'token' => $token,
        ]);
    }

    public function storeTools(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate(['title' => 'required', 'description' => 'required', 'type' => 'required']);
        if (isset($data['size'])) {
            $data['size'] = str_replace(',', '.', $data['size']);
        }

        $pa_data = new tb_perangkatAjar;
        $pa_data->title = $data['title'];
        $pa_data->description = $data['description'];
        $pa_data->type = $data['type'];
        if ($request->type == 'url') {
            $request->validate(['url' => 'required']);
            $pa_data->url = $request->url;
        } else {
            $request->validate(['file' => 'required']);
            $fileContents = file_get_contents($request->file('file')->getRealPath());
            $pa_data->size = $request->file('file')->getSize();
            $imageName = hash('sha256', $fileContents).'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->move('data-perangkatAjar', $imageName);
            $pa_data->url = 'data-perangkatAjar/'.$imageName;
        }
        $pa_data->save();

        return redirect()->route('tools.index', ['token' => $token]);
    }

    public function updateTools(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate(['title' => 'required', 'description' => 'required', 'type' => 'required']);
        if (isset($data['size'])) {
            $data['size'] = str_replace(',', '.', $data['size']);
        }

        $pa_data = tb_perangkatAjar::findOrFail($request->idName);
        $pa_data->title = $data['title'];
        $pa_data->description = $data['description'];
        $pa_data->type = $data['type'];
        $pa_data->size = $data['size'] ?? null;
        if ($request->type == 'url') {
            $request->validate(['url' => 'required']);
            $pa_data->url = $request->url;
        } else {
            $request->validate(['file' => 'required']);
            $fileContents = file_get_contents($request->file('file')->getRealPath());
            $imageName = hash('sha256', $fileContents).'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->move('data-perangkatAjar', $imageName);
            $pa_data->url = 'data-perangkatAjar/'.$imageName;
        }
        $pa_data->save();

        return redirect()->route('tools.index', ['token' => $token]);
    }

    public function editTools(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data_pa = tb_perangkatAjar::find($request->route('id'));

        return view('admin.page.perangkatAjar.edit', [
            'menu_active' => 'academic',
            'profile_active' => 'tools',
            'token' => $token,
            'pa' => $data_pa,
        ]);
    }

    public function destroyTools(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $pa_data = tb_perangkatAjar::findOrFail($request->idName);
        $pa_data->delete();

        return redirect()->route('tools.index', ['token' => $token]);
    }
}
