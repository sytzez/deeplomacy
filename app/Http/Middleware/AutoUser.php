<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoUser
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (! Auth::user()) {
            /** @var Authenticatable $user */
            $user = User::factory()->create();

            Auth::login($user);
        }

        return $next($request);
    }
}
