<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedBackResource extends JsonResource
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
            'title' => $this->title,
            'desc' => $this->desc,
            'user' => new UserResource($this->whenLoaded('user')),
            'upvotes' => $this->upvotes,
            'downvotes' => $this->downvotes,
            'created_at' => $this->created_at,
        ];
    }
}
