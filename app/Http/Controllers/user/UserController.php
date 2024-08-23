<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\tb_admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = tb_admin::orderBy('id_admin', 'desc')->get();

        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.management.user.index', [
            'menu_active' => 'user',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.page.management.user.create', [
            'menu_active' => 'user',
            'user' => tb_admin::all(),
            'token' => $token,
            'method' => 'insert',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'role' => 'required|in:1,2',
            'password' => 'required|string|min:6', // Add password validation rule
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'token' => 'required', // Add token validation rule
        ], [
            'nama.required' => 'Nama User wajib diisi.',
            'email.required' => 'Email User wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'username.required' => 'Username User wajib diisi.',
            'role.required' => 'Role User wajib dipilih.',
            'role.in' => 'Role User harus berupa Superadmin atau Admin.',
            'password.required' => 'Password User wajib diisi.', // Add password validation error message
            'password.min' => 'Password minimal memiliki 6 karakter.', // Add password length validation error message
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'token.required' => 'Token wajib diisi.', // Add token validation error message
        ]);

        $data = new tb_admin;
        $data->created_by = $request->session()->get('user')['name'];
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->username = $request->username;
        $data->role = $request->role;
        $data->token = $request->token; // assign token from request
        $data->password = Hash::make($request->password);

        if ($request->hasFile('image')) {
            if (file_exists('img/users/'.$data->image) && $data->image != null) {
                unlink('img/users/'.$data->image);
            }
            $file = $request->file('image');
            $imageName = md5($file->getClientOriginalName().microtime()).'.'.$file->getClientOriginalExtension();
            $file->move('img/users', $imageName);
            $data->image = $imageName;
        }
        $data->save();

        return redirect()->route('user.index', ['token' => $token])->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id, int $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id, int $user)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        $userInput = $request->route('user');
        $user = tb_admin::findOrFail($userInput);

        return view('admin.page.management.user.create', [
            'menu_active' => 'user',
            'user' => $user,
            'token' => $token,
            'method' => 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $token, int $user)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'role' => 'required|in:1,2',
            'password' => 'required|string|min:6', // Add password validation rule
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama User wajib diisi.',
            'email.required' => 'Email User wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'username.required' => 'Username User wajib diisi.',
            'role.required' => 'Role User wajib dipilih.',
            'role.in' => 'Role User harus berupa Superadmin atau Admin.',
            'password.required' => 'Password User wajib diisi.', // Add password validation error message
            'password.min' => 'Password minimal memiliki 6 karakter.', // Add password length validation error message
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = tb_admin::findOrFail($user);
        $data->created_by = $request->session()->get('user')['name'];
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->username = $request->username;
        $data->role = $request->role;
        $data->password = Hash::make($request->password);

        if ($request->hasFile('image')) {
            if (file_exists('img/users/'.$data->image) && $data->image != null) {
                unlink('img/users/'.$data->image);
            }
            $file = $request->file('image');
            $imageName = md5($file->getClientOriginalName().microtime()).'.'.$file->getClientOriginalExtension();
            $file->move('img/users', $imageName);
            $data->image = $imageName;
        }

        $data->save();

        return redirect()->route('user.index', ['token' => $token])->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $token, int $user)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $user = tb_admin::findOrFail($user);
        unlink('img/users/'.$user->image);
        $user->delete();
        return redirect()->route('user.index', ['token' => $token])->with('success', 'User berhasil dihapus.');
    }
}
