<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<\App\Models\Media>
 */
class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->getFullUrl(),
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
