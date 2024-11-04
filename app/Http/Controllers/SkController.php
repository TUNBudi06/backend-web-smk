<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkResource;
use App\Models\tb_slider_keunggulan;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SkController extends Controller
{
    public function indexSlider(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $perpage = $request->input('show') ?? 10;
        $sliders = tb_slider_keunggulan::paginate($perpage);
        $count = tb_slider_keunggulan::count();
        $action = $request->session()->get('update') ? 'update' : '';

        return view('admin.page.slider.index', [
            'menu_active' => 'links',
            'profile_active' => 'slider',
            'action' => $action,
            'sliders' => $sliders,
            'count' => $count,
            'token' => $token,
        ]);
    }

    public function storeSlider(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        $slider = new tb_slider_keunggulan;
        $slider->title = $data['title'];
        $slider->description = $request->description;
        $slider->save();

        return redirect()->route('slider.index', ['token' => $token])->with('success', 'Data berhasil ditambahkan');
    }

    public function editSlider(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $sliders = tb_slider_keunggulan::get();
        $slider = tb_slider_keunggulan::findOrFail($request->route('id'));
        $action = 'update';

        return view('admin.page.slider.index', [
            'menu_active' => 'links',
            'profile_active' => 'slider',
            'action' => $action,
            'sliders' => $sliders,
            'slider' => $slider,
            'token' => $token,
        ]);
    }

    public function updateSlider(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        $slider = tb_slider_keunggulan::findOrFail($request->idName);
        $slider->title = $data['title'];
        $slider->description = $request->description;
        $slider->save();

        return redirect()->route('slider.index', ['token' => $token])->with('success', 'Data berhasil diubah');
    }

    public function destroySlider(Request $request)
    {
        $token = $request->session()->get('token') ?? $request->input('token');
        $id = $request->idName;
        $slider = tb_slider_keunggulan::findOrFail($id);
        $slider->delete();

        return redirect()->route('slider.index', ['token' => $token])->with('success', 'Data berhasil dihapus');
    }

    /**
     * @OA\Get(
     *     path="/api/user/slider/keunggulan",
     *     tags={"Slider Keunggulan"},
     *     summary="Get Slider Keunggulan",
     *     description="Retrieve Slider Keunggulan",
     *     operationId="getSliderKeunggulan",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Data ditemukan",
     *
     *     @OA\JsonContent(
     *
     *     @OA\Property(property="message", type="string", example="Data ditemukan"),
     *     @OA\Property(property="data", type="array",
     *
     *      @OA\Items(ref="#/components/schemas/SkResource")
     *    )
     *  )
     * )
     * )
     */
    public function apiSlider(Request $request)
    {
        $sliders = tb_slider_keunggulan::get();

        return response()->json([
            'message' => 'data ditemukan',
            'data' => SkResource::collection($sliders),
        ]);
    }
}
