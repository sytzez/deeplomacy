<?php

namespace App\Http\Controllers;

use App\Models\User;

class TokenController extends Controller
{
    /**
     * @return array<string, string>
     */
    public function show(): array
    {
        /** @var User $user */
        $user = User::factory()->create();

        $token = $user->createToken('main');

        return ['data' => $token->plainTextToken];
    }
}
