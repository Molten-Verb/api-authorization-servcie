<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validate([

        ]);

        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password,
        ]);

        if (!empty($token)) {
            $user = User::firstWhere('email', $request->email);

            return new UserResource($user, $token);
        }

        return response()->json([
            "status" => 500,
        ]);
    }
}
