<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
