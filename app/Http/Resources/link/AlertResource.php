<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AlertResource",
 *     type="object",
 *
 *     @OA\Property(
 *         property="id_alert",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="alert_title",
 *         type="string",
 *         example="Don't miss"
 *     ),
 *     @OA\Property(
 *         property="icon_type",
 *         type="string",
 *         example="Alert"
 *     ),
 *     @OA\Property(
 *         property="alert_url",
 *         type="string",
 *         example="https://..."
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         example="2023-01-01T12:00:00Z"
 *     )
 * )
 */
class AlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_alert' => $this->id_alert,
            'alert_title' => $this->alert_title,
            'icon_type' => 'Alert',
            'alert_url' => $this->alert_url,
            'updated_at' => $this->updated_at,
        ];
    }
}
