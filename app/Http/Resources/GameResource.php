<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'configuration' => new ConfigurationResource($this->configuration),
            'numOfPlayers'  => $this->numOfPlayers,
            'isJoined'      => $this->isJoinedBy(auth()->user()),
        ];
    }
}
