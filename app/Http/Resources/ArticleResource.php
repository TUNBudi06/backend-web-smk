<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pemberitahuan' => $this->id_pemberitahuan,
            'nama' => $this->nama,
            'thumbnail' => $this->thumbnail,
            'date' => $this->date,
            'text' => $this->text,
            'level' => $this->level,
            'category' => [
                'id' => $this->kategori->id_pemberitahuan_category,
                'nama' => $this->kategori->pemberitahuan_category_name,
            ],
            'viewer' => $this->viewer,
            'created_at' => $this->created_at,
        ];
    }
}
