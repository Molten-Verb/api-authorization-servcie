<?php

namespace Tests;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function seedRoles()
    {
        $adminServiceRole = Role::create(['name' => 'service admin']);
        $companyOwnerRole = Role::create(['name' => 'company owner']);
        $adminCompanyRole = Role::create(['name' => 'company admin']);
        $userRole = Role::create(['name' => 'company user']);
    }

    public function createData()
    {
        $company = Company::create(['name' => 'А-Кор', 'email' => 'a-kor@mail.com']);
        $user = User::create();

        $company->users()->attach($user->id);
        $admin->roles()->attach($adminServiceRole->id, ['company_id' => $company->id]);
    }
}
