<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $alerts = tb_alert::get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.alert', [
            'menu_active' => 'links',
            'action' => $action,
            'alerts' => $alerts,
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
    public function edit(Request $request)
    {
        $id_position = $request->route('alert');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $alerts = tb_alert::findOrFail($id_position);
        $data = [
            'alerts' => $alerts,
            'update' => $action,
        ];

        return redirect()->route('alert.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'alert_title' => 'required',
            'alert_url' => 'required',
        ]);
        $alert = $request->route('alert');

        // Update data alert
        $alert = tb_alert::findOrFail($alert);
        $alert->update([
            'alert_title' => $request->alert_title,
            'alert_url' => $request->alert_url,
        ]);

        return redirect()->route('alert.index', ['token' => $request->token])->with('success', 'Alert berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
