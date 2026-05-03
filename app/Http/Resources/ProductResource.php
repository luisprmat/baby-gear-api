<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'daily_rate' => (float) $this->daily_rate,
            'category' => $this->category,
            'is_active' => (bool) $this->is_active,
            'units_count' => $this->whenCounted('units'),
        ];
    }
}
