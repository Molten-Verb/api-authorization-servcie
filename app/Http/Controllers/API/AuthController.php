<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserActivateRequest;
use App\Http\Resources\UserResource;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $email = $request->validated('email');

        $token = JWTAuth::attempt([
            'email' => $email,
            'password' => $request->validated('password'),
        ]);

        if (!empty($token)) {
            $user = User::firstWhere('email', $email);

            return (new UserResource($user))->additional([
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => 500,
        ]);
    }

    public function activateUser(UserActivateRequest $request): JsonResponse
    {
        $email = $request->validated('email');
        $name = $request->validated('name');
        $surname = $request->validated('surname');
        $token = $request->validated('token');

        $user = User::firstWhere('email', $email);
        $findToken = Invitation::firstWhere('token', $token);

        if (empty($user) || empty($findToken)) {

            return response()->json(['status' => 500]);
        }

        $user->update([
            'name' => $name,
            'surname' => $surname,
            'password' => Hash::make($request->validated('password')),
        ]);

        return response()->json(['status' => 200]);
    }
}
