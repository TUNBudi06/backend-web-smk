<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\profile\ElearningResource;
use App\Models\tb_elearning;
use Illuminate\Http\Request;

class ElearningApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/profile/e-learning",
     *     tags={"E-Learning"},
     *     summary="Get all E-Learning",
     *     description="Retrieve all E-Learning including badge",
     *     operationId="getAllElearning",
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
     *                 @OA\Items(ref="#/components/schemas/ElearningResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $elearning = tb_elearning::with('badges')->get();

        return response()->json([
            'message' => 'data ditemukan',
            'List' => ElearningResource::collection($elearning),
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
