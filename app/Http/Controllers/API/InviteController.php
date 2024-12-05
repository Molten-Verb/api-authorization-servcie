<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\InviteUserRequest;
use App\Http\Requests\UserActivateRequest;
use App\Http\Requests\InviteCompanyRequest;

class InviteController extends Controller
{
    public function inviteCompany(InviteCompanyRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->email,
        ]);

        $inviteToken = JWTAuth::fromUser($user);

        $invite = Invitation::create([
            'email' => $request->email,
            'token' => $inviteToken,
        ]);

        $company = Company::create(['name' => $request->name,]);
        $company->users()->attach($user->id);

        $role = Role::firstWhere('name', 'company owner');
        $user->roles()->attach($role->id, ['company_id' => $company->id]);

        return response()->json([
            'status' => 200,
            'Invite Token' => $inviteToken,
        ]);
    }

    public function inviteUser(InviteUserRequest $request): JsonResponse
    {
        $user = User::firstOrCreate(['email' => $request->email]);
        $company = Company::firstWhere('name', $request->company);

        $user->companies()->attach($company);

        foreach ($request->roles as $role) {
            $user->roles()->attach($role, ['company_id' => $company->id]);
        }

        $inviteToken = JWTAuth::fromUser($user);

        Invitation::create([
            'email' => $request->email,
            'token' => $inviteToken,
        ]);

        return response()->json([
            'status' => 200,
            'token' => $inviteToken
        ]);
    }

    public function activateUser(UserActivateRequest $request): JsonResponse
    {
        $user = User::firstWhere('email', $request->email);
        $findToken = Invitation::firstWhere('token', $request->token);

        if (empty($user) || empty($findToken)) {

            return response()->json(['status' => 500]);
        }

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['status' => 200]);
    }
}
