<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class SpaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $space): Response
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (! Auth::user()->belongToAnySpace($spaces)) {
            throw new Exception('You don\'t have access to that space.', 403);
        }

        return $next($request);
    }
}
