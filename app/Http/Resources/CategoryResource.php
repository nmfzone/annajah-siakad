<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<\App\Models\Category>
 */
class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'parent' => $this->whenLoaded('parent'),
            'parents' => $this->whenLoaded('parents'),
            'children' => $this->whenLoaded('children'),
            'all_children' => $this->whenLoaded('allChildren'),
        ];
    }
}
