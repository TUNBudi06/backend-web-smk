<?php

namespace App\Http\Controllers\profile;

use App\Models\tb_peserta_didik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdController extends Controller
{
    /**
     * Menampilkan daftar peserta didik.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $peserta_didik = tb_peserta_didik::orderBy('id', 'desc')->paginate($perPage);
    
        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.page.profile.peserta_didik.index', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
            'token' => $token,
            'pd' => $peserta_didik,
        ]);
    }
    
    /**
     * Menampilkan form untuk membuat peserta didik baru.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.peserta_didik.create', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
            'token' => $token,
        ]);
    }

    /**
     * Menyimpan data peserta didik yang baru dibuat.
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            // Sesuaikan validasi dengan kolom-kolom pada tabel tb_peserta_didik
        ]);

        tb_peserta_didik::create($request->all());
        return redirect()->route('pd.index', ['token' => $token])->with('success', 'Data peserta didik berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail peserta didik.
     */
    public function show(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $pd = tb_peserta_didik::findOrFail($id);

        return view('admin.page.profile.peserta_didik.show', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
            'token' => $token,
            'pd' => $pd,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit peserta didik.
     */
    public function edit(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $pd = tb_peserta_didik::findOrFail($id);

        return view('admin.page.profile.peserta_didik.edit', [
            'menu_active' => 'profile',
            'profile_active' => 'pd',
            'token' => $token,
            'pd' => $pd,
        ]);
    }

    /**
     * Mengupdate data peserta didik yang telah diubah.
     */
    public function update(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            // Sesuaikan validasi dengan kolom-kolom pada tabel tb_peserta_didik
        ]);

        $pd = tb_peserta_didik::findOrFail($id);
        $pd->update($request->all());

        return redirect()->route('pd.index', ['token' => $token])->with('success', 'Data peserta didik berhasil diperbarui.');
    }

    /**
     * Menghapus data peserta didik.
     */
    public function destroy(Request $request, string $id)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $pd = tb_peserta_didik::findOrFail($id);
        $pd->delete();

        return redirect()->route('pd.index', ['token' => $token])->with('success', 'Data peserta didik berhasil dihapus.');
    }
}
