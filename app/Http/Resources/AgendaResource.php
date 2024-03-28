<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgendaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_event' => $this->id_event,
            'event_name' => $this->event_name,
            'event_date' => $this->event_date,
            'event_type' => $this->event_type,
            'event_text' => $this->event_text,
            'event_location' => $this->event_location,
        ];
    }
}
