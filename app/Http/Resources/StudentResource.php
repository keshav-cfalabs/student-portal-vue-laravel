<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
   
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'class' => ClassesResource::make($this->whenLoaded('class')),
            'section' => SectionResource::make($this->whenLoaded('section')),
            'created_at' => $this->created_at->format('M d, Y'),
        ];
    }
}
