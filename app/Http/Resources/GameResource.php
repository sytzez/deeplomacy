<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
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
