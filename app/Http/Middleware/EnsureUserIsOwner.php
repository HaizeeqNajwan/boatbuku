<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()?->isOwner()) {
            abort(403, "Only boat owners can access this area.");
        }
        return $next($request);
    }
}
