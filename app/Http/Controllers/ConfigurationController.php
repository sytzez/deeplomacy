<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use Illuminate\Contracts\Support\Responsable;

class ConfigurationController extends Controller
{
    public function index(): Responsable
    {
        return ConfigurationResource::collection(
            Configuration::all()
        );
    }

    public function show(Configuration $configuration): Responsable
    {
        return new ConfigurationResource($configuration);
    }
}
