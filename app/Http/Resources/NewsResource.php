<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_news' => $this->id_news,
            'news_title' => $this->news_title,
            'id_category' => $this->category_news->category_name,
            'news_level' => $this->news_level,
            'news_image' => $this->news_image,
            'news_content' => $this->news_content,
            'news_location' => $this->news_location,
            'news_viewer' => $this->news_viewer,
        ];
    }
}
