<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  use HttpResponses;

  public function login(): JsonResponse
  {
    return response()->json('This is my login');
  }

  public function register(): JsonResponse
  {
    return response()->json('This is my register');
  }
  public function logout(): JsonResponse
  {
    return response()->json('This is my logout');
  }
}
