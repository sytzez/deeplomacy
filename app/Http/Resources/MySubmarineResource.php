<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MySubmarineResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'x'            => $this->x,
            'y'            => $this->y,
            'actionPoints' => $this->action_points,
        ];
    }
}
