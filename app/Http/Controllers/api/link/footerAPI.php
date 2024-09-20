<?php

namespace App\Http\Controllers\api\link;

use App\Http\Controllers\Controller;
use App\Http\Resources\FooterSChemas;
use App\Models\link\tb_footer;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class footerAPI extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/footer",
     *     tags={"Footer navigation"},
     *     summary="Get Footer Navigation",
     *     description="Retrieve Footer Navigation",
     *     operationId="getFooterNavigation",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Data ditemukan",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="message", type="string", example="Data ditemukan"),
     *          @OA\Property(property="List", type="array",
     *
     *              @OA\Items(
     *
     *                  @OA\Property(property="1", type="string", example="Unit Produksi Sekolah"),
     *                  @OA\Property(property="data", type="array",
     *
     *                      @OA\Items(ref="#/components/schemas/FooterSchemas")
     *                  )
     *              ),
     *              @OA\Items(
     *
     *                  @OA\Property(property="2", type="string", example="Aplikasi & Layanan"),
     *                  @OA\Property(property="data", type="array",
     *
     *                      @OA\Items(ref="#/components/schemas/FooterSchemas")
     *                  )
     *              ),
     *              @OA\Items(
     *
     *                  @OA\Property(property="3", type="string", example="Lainnya"),
     *                  @OA\Property(property="data", type="array",
     *
     *                      @OA\Items(ref="#/components/schemas/FooterSchemas")
     *                  )
     *              )
     *          )
     *      )
     *     )
     * )
     */
    public function footer(Request $request)
    {
        $ups = tb_footer::where('type', 1)->get();
        $apl = tb_footer::where('type', 2)->get();
        $lain = tb_footer::where('type', 3)->get();

        return response()->json([
            'message' => 'data ditemukan',
            'List' => [
                ['1' => 'Unit Produksi Sekolah',
                    'data' => FooterSChemas::collection($ups),
                ],
                ['2' => 'Aplikasi & Layanan',
                    'data' => FooterSChemas::collection($apl),
                ],
                ['3' => 'Lainnya',
                    'data' => FooterSChemas::collection($lain),
                ],
            ],
        ]);
    }
}
