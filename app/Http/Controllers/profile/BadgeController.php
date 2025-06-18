<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\tb_badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $perpage = $request->input('show') ?? 10;
        $badge = tb_badge::paginate($perpage);
        $count = tb_badge::count();
        $action = $_GET['action'] ?? '';

        return view('admin.page.profile.badge.index', [
            'menu_active' => 'jurusan',
            'action' => $action,
            'badge' => $badge,
            'token' => $token,
            'count' => $count,
            'category' => $request->session()->get('category') ?? null,
            'action' => $request->session()->get('update') ?? false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'create';
        $data = [
            'update' => $action,
        ];

        return redirect()->route('badge.index', $token)->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required',
            'icon' => 'required',
        ]);

        $data = new tb_badge();
        $data->label = $request->label;
        $data->elearning_id = $request->elearning_id ?? null;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $imageName = md5($file->getClientOriginalName().microtime()).'.'.$file->getClientOriginalExtension();
            $file->move('img/badge', $imageName);
            $data->icon = $imageName;
        } else {
            $data->icon = 'img/no_image.png';
        }

        $data->save();

        return redirect()->route('badge.index', ['token' => $request->token])->with('success', 'Badge berhasil ditambahkan.');
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
    public function edit(Request $request)
    {
        $id = $request->route('badge');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $category = tb_badge::findOrFail($id);
        $data = [
            'category' => $category,
            'update' => $action,
        ];

        return redirect()->route('badge.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'label' => 'required',
        ]);
        $badge = $request->route('badge');

        $data = tb_badge::findOrFail($badge);

        if ($request->hasFile('icon')) {
            // Hapus gambar sebelumnya jika ada
            if (! empty($data->icon)) {
                $oldImagePath = public_path('img/badge/'.$data->icon);
                if (file_exists($oldImagePath) && ! is_dir($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar baru
            $imageName = $request->file('icon')->hashName();
            $request->file('icon')->move('img/badge', $imageName);
            $data->icon = $imageName;
        }

        $data->update([
            'label' => $request->label,
            'elearning_id' => $request->elearning_id ?? null,
        ]);

        return redirect()->route('badge.index', ['token' => $request->token])->with('success', 'Badge berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->route('badge');
        $token = $request->session()->get('token') ?? $request->input('token');

        $badge = tb_badge::findOrFail($id);
        $imagePath = public_path('img/badge/'.$badge->icon);
        $badge->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->route('badge.index', ['token' => $token])->with('success', 'Badge berhasil dihapus.');
    }
}
