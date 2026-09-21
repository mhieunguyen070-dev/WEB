<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
        ];
    }
}