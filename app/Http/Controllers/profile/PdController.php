<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Imports\PDImport;
use App\Models\tb_peserta_didik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PdController extends Controller
{
    /**
     * Menampilkan daftar peserta didik.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);

        [$pd, $count] = Concurrency::run([
            fn () => Cache::flexible('peserta_didik_' . request('page', 1) . '_show_' . $perPage, [2, 20], function () use ($perPage) {
                return tb_peserta_didik::orderBy('id', 'desc')->paginate($perPage);
            }),
            fn () => DB::table('tb_peserta_didik')
                ->count(),
        ]);

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.peserta_didik.index', [
            'menu_active' => 'academic',
            'profile_active' => 'pd',
            'token' => $token,
            'pd' => $pd,
            'count' => $count,
        ]);
    }

    /**
     * Menampilkan form untuk membuat peserta didik baru.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.profile.peserta_didik.create', [
            'menu_active' => 'academic',
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
            'nisn' => 'required|numeric',
            'nis' => 'required|numeric',
            'nama' => 'required',
            'kelas' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'gender' => 'required',
            'telp' => 'required|numeric',
            'alamat' => 'required',

        ], [
            'nisn.required' => 'Kolom nisn harus diisi.',
            'nis.required' => 'Kolom nis harus diisi.',
            'nama.required' => 'Kolom nama harus diisi.',
            'kelas.required' => 'Kolom kelas harus diisi.',
            'tampat_lahir.required' => 'Kolom tempat lahir harus diisi.',
            'tanggal_lahir.required' => 'Kolom tanggal lahir harus diisi.',
            'agama.required' => 'Kolom agama harus diisi',
            'gender.required' => 'Kolom gender harus diisi.',
            'telp.required' => 'Kolom telp harus diisi.',
            'alamat.required' => 'Kolom alamat harus diisi.',
        ]);

        tb_peserta_didik::create($request->all());

        return redirect()->route('pd.index', ['token' => $token])->with('success', 'Data peserta didik berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail peserta didik.
     */
    public function show(Request $request, string $id)
    {
        $id = $request->route('pd');
        $token = $request->session()->get('token') ?? $request->input('token');
        $pd = tb_peserta_didik::findOrFail($id);

        return view('admin.page.profile.peserta_didik.show', [
            'menu_active' => 'academic',
            'profile_active' => 'pd',
            'token' => $token,
            'pd' => $pd,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit peserta didik.
     */
    public function edit(Request $request)
    {
        $id = $request->route('pd');
        $token = $request->session()->get('token') ?? $request->input('token');
        $pd = tb_peserta_didik::findOrFail($id);

        return view('admin.page.profile.peserta_didik.edit', [
            'menu_active' => 'academic',
            'profile_active' => 'pd',
            'token' => $token,
            'pd' => $pd,
        ]);
    }

    /**
     * Mengupdate data peserta didik yang telah diubah.
     */
    public function update(Request $request)
    {
        $id = $request->route('pd');
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'nisn' => 'required|numeric',
            'nis' => 'required|numeric',
            'nama' => 'required',
            'kelas' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'gender' => 'required',
            'telp' => 'required|numeric',
            'alamat' => 'required',
        ], [
            'nisn.required' => 'Kolom nisn harus diisi.',
            'nis.required' => 'Kolom nis harus diisi.',
            'nama.required' => 'Kolom nama harus diisi.',
            'kelas.required' => 'Kolom kelas harus diisi.',
            'tempat_lahir.required' => 'Kolom tempat lahir harus diisi.',
            'tanggal_lahir.required' => 'Kolom tanggal lahir harus diisi.',
            'agama.required' => 'Kolom agama harus diisi',
            'gender.required' => 'Kolom gender harus diisi.',
            'telp.required' => 'Kolom telp harus diisi.',
            'alamat.required' => 'Kolom alamat harus diisi.',
        ]);

        // Update data
        $pd = tb_peserta_didik::findOrFail($id);
        $pd->update([
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'gender' => $request->gender,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pd.index', ['token' => $token])->with('success', 'Data peserta didik berhasil diperbarui.');
    }

    /**
     * Menghapus data peserta didik.
     */
    public function destroy(Request $request, string $id)
    {
        $id = $request->route('pd');
        $token = $request->session()->get('token') ?? $request->input('token');

        $pd = tb_peserta_didik::findOrFail($id);
        $pd->delete();

        return redirect()->route('pd.index', ['token' => $request->token])->with('success', 'Peserta Didik berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $request->validate([
            'excel_file' => 'required|file|mimes:xls,xlsx',
        ]);

        Excel::import(new PDImport(), $request->file('excel_file'));

        return redirect()->route('pd.index', ['token' => $token])->with('success', 'Peserta Didik berhasil diimport.');
    }
}
