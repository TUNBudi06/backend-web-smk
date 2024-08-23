<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $videos = tb_video::get();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.video', [
            'menu_active' => 'profile',
            'profile_active' => 'video',
            'action' => $action,
            'videos' => $videos,
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
        $id_position = $request->route('video');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $request->session()->put('token', $token);
        $videos = tb_video::findOrFail($id_position);
        $data = [
            'videos' => $videos,
            'update' => $action,
        ];

        return redirect()->route('video.index', $token)->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'video_url' => 'required',
        ]);
        $video = $request->route('video');

        // Update data video
        $video = tb_video::findOrFail($video);
        $video->update([
            'video_title' => $request->video_title,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('video.index', ['token' => $request->token])->with('success', 'Video berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
