<?php

namespace App\Http\Controllers;

use App\Models\tb_event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $event = tb_event::orderBy('event_timestamp', 'desc')->paginate($perPage);

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
            'event_date' => 'required|date',
            'event_type' => 'required',
            'event_text' => 'required',
            'event_location' => 'required',
        ]);

        tb_event::create($request->all());
        return redirect()->route('event.index', ['token' => $token])->with('success', 'Data added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_event = $request->route("event");
        $token = $request->session()->get('token') ?? $request->input('token');
        $event = tb_event::findOrFail($id_event);
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
            'event_date' => 'required|date',
            'event_type' => 'required',
            'event_text' => 'required',
            'event_location' => 'required',
        ]);

        $event = tb_event::findOrFail($id_event);
        $event->update($request->all());

        return redirect()->route('event.index', ['token' => $request->token])->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_event = $request->route("event");
        $token = $request->session()->get('token') ?? $request->input('token');

        $event = tb_event::findOrFail($id_event);
        $event->delete();

        return redirect()->route('event.index', ['token' => $request->token])->with('success', 'Data deleted successfully.');
    }
}
