<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class GameController extends Controller
{
    public function index(): Renderable
    {
        return View::make('games.index');
    }

    public function create(): Renderable
    {
        return View::make('games.create');
    }

    public function store(Request $request): Response
    {
        //
    }

    public function show(int $id): Response
    {
        //
    }

    public function edit(int $id): Response
    {
        //
    }

    public function update(Request $request, int $id): Response
    {
        //
    }

    public function destroy(int $id): Response
    {
        //
    }
}
