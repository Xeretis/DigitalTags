<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRefreshRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService\Actions\CreateRefreshTokenAction;
use App\Services\AuthService\Actions\CreateSessionAction;
use App\Services\AuthService\Actions\CreateUserAction;
use App\Services\AuthService\Actions\DeleteRefreshAction;
use App\Services\AuthService\Actions\DeleteSessionAction;
use App\Services\AuthService\Actions\RefreshSessionAction;
use App\Services\AuthService\Data\CreateRefreshTokenData;
use App\Services\AuthService\Data\CreateUserData;
use App\Services\AuthService\Data\DeleteRefreshData;
use App\Services\AuthService\Data\DeleteSessionData;
use App\Services\AuthService\Data\RefreshSessionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = CreateUserData::from($request->validated());

        CreateUserAction::dispatch($data);

        return jsend()->success()->message("Successfully created user")->get();
    }

    public function login(LoginRequest $request) {
        if (!Auth::attempt($request->only(["email", "password"]))) {
            return jsend()->fail()->errors(['email' => ['Invalid credentials']])->get();
        }

        $token = CreateSessionAction::run();

        if ($request->validated('remember')) {
            $data = new CreateRefreshTokenData(null);

            $refreshToken = CreateRefreshTokenAction::run($data);

            Cookie::queue('refresh_token', $refreshToken);
        }

        return jsend()->success()->data([
            'user' => auth()->user(),
            'token' => $token
        ])->get();
    }

    public function logout(LogoutRequest $request) {
        $data = DeleteSessionData::from($request->validated());

        Cookie::expire('refresh_token');
        DeleteSessionAction::dispatch($data);

        return jsend()->success()->message('Successfully logged out')->get();
    }

    public function logoutRefresh(LogoutRefreshRequest $request) {
        $data = DeleteRefreshData::from($request->validated());

        DeleteRefreshAction::dispatch($data);
        Cookie::expire('refresh_token');

        return jsend()->success()->message('Successfully logged out')->get();
    }

    public function user() {
        return jsend()->success()->data(['user' => auth()->user()])->get();
    }

    public function refresh(Request $request) {
        $tokenCookie = $request->cookie('refresh_token');

        if ($tokenCookie === null) {
            return jsend()->fail()->message('No refresh token cookie set')->get();
        }

        $data = new RefreshSessionData($tokenCookie);
        $tokens = RefreshSessionAction::run($data);

        if ($tokens === null) {
            return jsend()->fail()->message('Invalid refresh token')->get();
        }

        Cookie::queue('refresh_token', $tokens['refreshToken']);

        return jsend()->success()->data([
            'user' => auth()->user(),
            'token' => $tokens['accessToken']
        ])->get();
    }
}
