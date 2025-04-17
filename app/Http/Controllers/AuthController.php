<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Trait\HttpResponses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use HttpResponses;

    private function generateTokensAndCookies($user)
    {
        $user->tokens()->delete();
        $accessToken = $user->createToken($user->name, ['ability'], Carbon::now()->addMinutes(60 * 5))->plainTextToken;
        $refreshToken = Str::random(60);
        $user->update(['refresh_token' => $refreshToken]);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        Auth::login($user);

        $tokens = $this->generateTokensAndCookies($user);

        return $this->success([
            'user' => new UserResource($user),
        ], 'You Logged In Successfully With Role: ' . $user->account_type, 200, $tokens);
    }


    public function register(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $tokens = $this->generateTokensAndCookies($user);

        return $this->success([
            'user' => new UserResource($user),
        ], 'You Signed Up Successfuly', 201, $tokens);
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $token = PersonalAccessToken::where('name', $user->name)->first();
        $token->delete();
        $user->update(['refresh_token' => null]);
        return $this->success('', 'LogOut Done Successfuly');
    }

    public function isLogged(Request $request)
    {
        $accessToken = $request->cookie('access_token');
        $refreshToken = $request->cookie('refresh_token');

        if (!$accessToken) {
            return $this->success(['authenticated' => false, 'user' => null]);
        }

        $accessToken = PersonalAccessToken::findToken($accessToken);

        if (!$accessToken) {
            return $this->success(['authenticated' => false, 'user' => null]);
        }

        $expiresAt = Carbon::parse($accessToken->expires_at);

        if ($expiresAt->lessThan(Carbon::now())) {
            return $this->success(['authenticated' => false, 'user' => null]);
        }

        $user = $accessToken->tokenable;

        if (!$user || !$refreshToken || $refreshToken !== $user->refresh_token) {
            return $this->success(['authenticated' => false, 'user' => null]);
        }

        return $this->success(['authenticated' => true, 'user' => $user]);
    }
}
