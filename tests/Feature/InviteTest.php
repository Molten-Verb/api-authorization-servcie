<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\API\InviteController;
use Illuminate\Database\Eloquent\Factories\Factory;

class InviteTest extends TestCase
{
    public function test_company_can_be_invited()
    {
        $this->seedRoles();

        $email = strtolower(fake()->unique()->safeEmail());
        $name = fake()->company();

        $this->postJson($this->routeInviteCompany([
            'email' => $email,
            'name' => $name,
            ]))
            ->assertOk();

        $this->assertDatabaseHas('invitations', [
            'email' => $email,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    public function test_user_can_be_invited()
    {
        $this->seedRoles();

        $email = strtolower(fake()->unique()->safeEmail());

        $user = User::factory()->create(['email' => $email]);
        $company = Company::factory()->create();
        $role = Role::firstWhere('name', 'company user');

        $this->postJson($this->routeInviteUser([
            'email' => $email,
            'company' => $company->name,
            'roles' => [$role->id],
            ]))
            ->assertOk();
    }

    public function routeInviteCompany(array $params = []): string
    {
        return action([InviteController::class, 'inviteCompany'], $params);
    }

    public function routeInviteUser(array $params = []): string
    {
        return action([InviteController::class, 'inviteUser'], $params);
    }
}
