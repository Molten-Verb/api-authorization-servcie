<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\AuthController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    public function test_user_can_be_activated(): void
    {
        $this->seedRoles();

        $user = User::factory()->create();
        $invatation = Invitation::factory()->create();
        $name = fake()->name();
        $surname = fake()->name();
        $password = Str::random(10);

        $this->postJson($this->routeActivate([
            'email' => $user->email,
            'name' => $name,
            'surname' => $surname,
            'token' => $invatation->token,
            'password' => $password,
            ]))
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'surname' => $surname,
        ]);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $this->postJson($this->routeLogin([
            'email' => $user->email,
            'password' => $user->password,
            ]))
            ->assertOk();
    }

    public function routeActivate(array $params = []): string
    {
        return action([AuthController::class, 'activateUser'], $params);
    }

    public function routeLogin(array $params = []): string
    {
        return action([AuthController::class, 'login'], $params);
    }
}
