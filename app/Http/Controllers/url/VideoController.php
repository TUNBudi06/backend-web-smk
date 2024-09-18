<?php

namespace App\Http\Controllers\url;

use App\Http\Controllers\Controller;
use App\Models\url\tb_other;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $videos = tb_other::whereBetween('id_link', [1, 2])->get();
        $videos_kemitraan = tb_other::find(3);
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.url.video', [
            'menu_active' => 'profile',
            'profile_active' => 'video',
            'kemitraan' => $videos_kemitraan,
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
    public function show(Request $request, string $id)
    {
        $id_position = $request->route('video');
        $token = $request->session()->get('token') ?? $request->input('token');
        $video1 = tb_other::where('id_link', 1)->first();
        $video2 = tb_other::where('id_link', 2)->first();
        if ($id_position == 1) {
            $video1->is_used = true;
            $video2->is_used = false;
        } else {
            $video1->is_used = false;
            $video2->is_used = true;
        }
        $video1->save();
        $video2->save();

        return redirect()->route('video.index', ['token' => $token])->with('success', 'Video berhasil diubah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id_position = $request->route('video');
        $token = $request->session()->get('token') ?? $request->input('token');
        $action = 'update';
        $videos_kemitraan = tb_other::find(3);
        $request->session()->put('token', $token);
        $video = tb_other::findOrFail($id_position);
        $videos = tb_other::whereBetween('id_link', [1, 2])->get();

        return view('admin.page.url.video', [
            'menu_active' => 'profile',
            'profile_active' => 'video',
            'kemitraan' => $videos_kemitraan,
            'action' => $action,
            'video' => $video,
            'videos' => $videos,
            'token' => $token,
        ]);
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
        $video = tb_other::findOrFail($video);
        $video->url = $request->video_url;
        $video->title = $request->video_title;
        $video->description = $request->video_description;
        $video->save();

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
