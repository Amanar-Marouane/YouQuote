<?php

namespace App\Http\Middleware;

use App\Http\Trait\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class isNotLoged
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token = $request->cookie('access_token');
        if (!$access_token) {
            return $next($request);
        }

        $access_token = PersonalAccessToken::findToken($access_token);
        if (!$access_token) {
            return $next($request);
        }

        $user = $access_token->tokenable;
        if (!$user) {
            return $next($request);
        }

        $expDate = Carbon::parse($access_token->expires_at);
        if ($expDate->greaterThanOrEqualTo(Carbon::now())) {
            return $this->error(null, 'Log Out First', 403);
        }

        $refresh_token = $user->refresh_token;
        if (!$request->cookie('refresh_token') || !Hash::check($request->cookie('refresh_token'), $refresh_token)) {
            return $next($request);
        }
        return $this->error(null, 'Log Out First', 403);
    }
}
