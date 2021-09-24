<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MySubmarineResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'x'            => $this->x,
            'y'            => $this->y,
            'actionPoints' => $this->action_points,
        ];
    }
}
