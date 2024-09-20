<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class FooterSChemas extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="FooterSchemas",
     *     title="FooterSchemas",
     *     description="FooterSchemas",
     *     @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="ID",
     *     example="1"
     *    ),
     *     @OA\Property(
     *     property="label",
     *     type="string",
     *     description="Label",
     *     example="Label"
     *   ),
     *     @OA\Property(
     *     property="url",
     *     type="string",
     *     description="URL",
     *     example="URL"
     *  ),
     *     @OA\Property(
     *     property="type",
     *     type="integer",
     *     description="Type",
     *     example="1"
     * ),
     * )
     *
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_footer,
            'label' => $this->label,
            'url' => $this->url,
            'type' => $this->type,
        ];
    }
}
