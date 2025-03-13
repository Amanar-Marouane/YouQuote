<?php

namespace App\Http\Middleware;

use App\Http\Trait\HttpResponses;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TokenVal
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
            return $this->error('Access token missing', 'Unauthenticated', 401);
        }

        $access_token = PersonalAccessToken::findToken($access_token);
        if (!$access_token) {
            return $this->error('Access token missing', 'Unauthenticated', 401);
        }
        $user = $access_token->tokenable;

        if (!$user) {
            return $this->error('Invalid token', 'Unauthenticated', 401);
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        $response = $next($request);

        $expDate = Carbon::parse($access_token->expires_at);
        if ($expDate->greaterThanOrEqualTo(Carbon::now())) {
            return $response;
        }

        $refresh_token = $user->refresh_token;
        if (!$request->cookie('refresh_token') || Hash::check($request->cookie('refresh_token'), $refresh_token)) {
            return $this->error('', 'Unauthenticated', 401);
        }

        $access_token->delete();

        $access_token = $user->createToken($user->name, ['ability'], Carbon::now()->addMinutes(60 * 5))->plainTextToken;
        $cookie = cookie('access_token', $access_token, 1440, null, null, true, true);
        $response->headers->setCookie($cookie);
        return $response;
    }
}
