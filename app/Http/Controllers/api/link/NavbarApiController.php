<?php

namespace App\Http\Controllers\api\link;

use App\Http\Controllers\Controller;
use App\Http\Resources\link\NavbarResource;
use App\Models\tb_navbar;
use App\Models\tb_sub_navbar;
use Illuminate\Http\Request;

class NavbarApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/navbar",
     *     tags={"Navbar"},
     *     summary="Get all Navbar with optional sub_navbars",
     *     description="Retrieve all Navbar data, including sub_navbars if available",
     *     operationId="getAllNavbar",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="data ditemukan"),
     *             @OA\Property(
     *                 property="List",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/NavbarResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $navbar = tb_navbar::with('subNavbars')->get();

        return response()->json([
            'message' => 'data ditemukan',
            'List' => NavbarResource::collection($navbar),
        ]);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
