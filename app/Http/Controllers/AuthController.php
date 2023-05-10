<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function ping(): JsonResponse
    {
        return response()->json('Ping - Running ...');
    }

    public function login(LoginUserRequest $req): JsonResponse
    {
        // return response()->json('This is my login');
        $req->validated($req->all());

        // Handle an authentication attempt.
        if (!Auth::attempt($req->only('email', 'password'))) {
            return $this->error([], 'Credentials do not match', 401);
        }

        $user = User::where('email', $req->email)->first();

        // https://laravel.com/docs/10.x/sanctum#issuing-api-tokens
        $token = $user->createToken('Api Token Of ' . $user->email);

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
        // return response()->json('This is my login');
    }

    public function register(StoreUserRequest $req): JsonResponse
    {
        // return response()->json('This is my register');
        $req->validated($req->all());

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        // https://laravel.com/docs/10.x/sanctum#issuing-api-tokens
        $token = $user->createToken('API Token of ' . $user->email);

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }
    public function logout(): JsonResponse
    {
        return response()->json('This is my logout');
    }
}
