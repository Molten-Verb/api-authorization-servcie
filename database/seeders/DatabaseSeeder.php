<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminServiceRole = Role::create(['name' => 'service admin']);
        $companyOwnerRole = Role::create(['name' => 'company owner']);
        $adminCompanyRole = Role::create(['name' => 'company admin']);
        $userRole = Role::create(['name' => 'company user']);

        $company = Company::create(['name' => 'А-Кор', 'email' => 'a-kor@mail.com']);

        $admin = User::create([
            'name' => 'Иван',
            'surname' => 'Иванов',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        $company->users()->attach($admin->id);
        $admin->roles()->attach($adminServiceRole->id, ['company_id' => $company->id]);
    }
}
