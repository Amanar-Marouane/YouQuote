<?php

namespace App\Http\Middleware;

use App\Http\Trait\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Carbon;

class isNotLoged
{
    use HttpResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->cookie('access_token');
        $refreshToken = $request->cookie('refresh_token');

        if (!$accessToken) {
            return $next($request);
        }

        $token = PersonalAccessToken::findToken($accessToken);

        if (!$token) {
            return $next($request);
        }

        if (Carbon::parse($token->expires_at)->lessThan(now())) {
            return $next($request);
        }

        $user = $token->tokenable;

        if (!$user || !$refreshToken || $refreshToken !== $user->refresh_token) {
            return $next($request);
        }

        return $this->error(null, 'Log Out First', 403);
    }
}
