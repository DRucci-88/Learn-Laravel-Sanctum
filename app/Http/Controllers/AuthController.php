<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function ping(): JsonResponse
    {
        return response()->json('Ping - Running ...');
    }

    public function login(): JsonResponse
    {
        return response()->json('This is my login');
    }

    public function register(StoreUserRequest $req): JsonResponse
    {
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
