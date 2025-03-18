<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'quote' => $this->quote,
            'content' => json_decode($this->content),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'frequency' => $this->frequency,
            'categories' => CategoryResource::collection($this->categories)->map(function ($item) {
                return $item->name;
            }),
            'tags' => TagResource::collection($this->tags)->map(function ($item) {
                return $item->tag;
            }),
            'likes' => count($this->likes),
        ];
    }
}
