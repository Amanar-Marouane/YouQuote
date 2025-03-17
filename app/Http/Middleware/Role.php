<?php

namespace App\Http\Middleware;

use App\Http\Trait\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->account_type != $role) {
            return $this->error(null, 'Not Authorized', 401);
        }
        return $next($request);
    }
}
