<?php

namespace App\Http\Controllers\link;

use App\Http\Controllers\Controller;
use App\Models\link\tb_footer;
use Illuminate\Http\Request;

class footerController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $perpage = $request->input('show', 10);
        $footers = tb_footer::paginate($perpage);
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.footer.index', [
            'menu_active' => 'links',
            'navlink_active' => 'footer',
            'action' => $action,
            'footers' => $footers,
            'count' => $footers->count(),
            'token' => $token,
        ]);
    }

    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate([
            'label' => 'required|string',
            'url' => 'required|url',
            'footer_tipe' => 'required|in:1,2,3',
        ]);

        $footer = new tb_footer;
        $footer->label = $data['label'];
        $footer->url = $data['url'];
        $footer->type = $data['footer_tipe'];
        $footer->save();

        return redirect()->route('footer', ['token' => $token])->with('success', 'Data berhasil ditambahkan');
    }

    public function destroy(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $id = $request->idName;
        $footer = tb_footer::findOrFail($id);
        $footer->delete();

        return redirect()->route('footer', ['token' => $token])->with('success', 'Data berhasil dihapus');
    }

    public function edit(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $footers = tb_footer::get();
        $footer = tb_footer::findOrFail($request->route('id'));
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.footer.index', [
            'menu_active' => 'links',
            'navlink_active' => 'footer',
            'action' => 'update',
            'footers' => $footers,
            'footer' => $footer,
            'token' => $token,
        ]);
    }

    public function update(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate([
            'label' => 'required|string',
            'url' => 'required|url',
            'footer_tipe' => 'required|in:1,2,3',
        ]);

        $footer = tb_footer::findOrFail($request->idName);
        $footer->label = $data['label'];
        $footer->url = $data['url'];
        $footer->type = $data['footer_tipe'];
        $footer->save();

        return redirect()->route('footer', ['token' => $token])->with('success', 'Data berhasil diubah');
    }
}
