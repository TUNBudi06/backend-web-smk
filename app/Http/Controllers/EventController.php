<?php

namespace App\Http\Controllers;

use App\Models\tb_event;
use App\Models\tb_pemberitahuan;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->orderBy('created_at', 'desc')->paginate($perPage);
//        return $event;
        $token = $request->session()->get('token') ?? $request->input('token');
        return view('admin.agenda.index', [
            'menu_active' => 'event',
            'token' => $token,
            'event' => $event,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');

        return view('admin.agenda.create', [
            'menu_active' => 'event',
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
            'event_name' => 'required',
            'event_type' => 'required',
            'event_text' => 'required',
            'event_date' => 'required|date',
            'event_location' => 'required',
        ], [
            'event_name.required' => 'Kolom nama agenda harus diisi.',
            'event_type.required' => 'Kolom tipe agenda harus diisi.',
            'event_text.required' => 'Kolom isi agenda harus diisi.',
            'event_date.required' => 'Kolom tanggal agenda harus diisi.',
            'event_date.date' => 'Kolom tanggal agenda harus dalam format tanggal yang benar.',
            'event_location.required' => 'Kolom lokasi agenda harus diisi.',
        ]);

        $event = new tb_pemberitahuan();
        $event->nama = $request->event_name;
        $event->target = $request->event_type;
        $event->text = $request->event_text;
        $event->date = $request->event_date;
        $event->location = $request->event_location;
        $event->type = 4;
        $event->save();
        return redirect()->route('event.index', ['token' => $token])->with('success', 'Agenda baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id_event = $request->route("event");
        $token = $request->session()->get('token') ?? $request->input('token');
        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);
        // dd($event);

        return view('admin.agenda.show', [
            'menu_active' => 'event',
            'token' => $token,
            'event' => $event,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_event = $request->route("event");
        $token = $request->session()->get('token') ?? $request->input('token');
        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);
        // dd($event);

        return view('admin.agenda.edit', [
            'menu_active' => 'event',
            'token' => $token,
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_event = $request->route("event");
        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_text' => 'required',
            'event_date' => 'required|date',
            'event_location' => 'required',
        ], [
            'event_name.required' => 'Kolom nama agenda harus diisi.',
            'event_type.required' => 'Kolom tipe agenda harus diisi.',
            'event_text.required' => 'Kolom isi agenda harus diisi.',
            'event_date.required' => 'Kolom tanggal agenda harus diisi.',
            'event_date.date' => 'Kolom tanggal agenda harus dalam format tanggal yang benar.',
            'event_location.required' => 'Kolom lokasi agenda harus diisi.',
        ]);

        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);
        $event->update([
            'nama' => $request->event_name,
            'target' => $request->event_type,
            'text' => $request->event_text,
            'date' => $request->event_date,
            'location' => $request->event_location,
        ]);

        return redirect()->route('event.index', ['token' => $request->token])->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_event = $request->route("event");
        $token = $request->session()->get('token') ?? $request->input('token');

        $event = tb_pemberitahuan::where(['tb_pemberitahuan.type' => 4])
            ->findOrFail($id_event);
        $event->delete();

        return redirect()->route('event.index', ['token' => $request->token])->with('success', 'Agenda berhasil dihapus.');
    }
}
