<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $admin = new User;
        $admin->name = 'Admin Name';
        $admin->email = 'admin@test.com';
        $admin->password = bcrypt('password');
        $admin->role_id = Role::ADMIN;
        $admin->save();

        $candidate = new User;
        $candidate->name = 'Candidate One';
        $candidate->email = 'candidate1@test.com';
        $candidate->password = bcrypt('password');
        $candidate->role_id = Role::CANDIDATE;
        $candidate->email_verified_at = now();
        $candidate->save();

        $candidate = new User;
        $candidate->name = 'Candidate Two';
        $candidate->email = 'candidate2@test.com';
        $candidate->password = bcrypt('password');
        $candidate->role_id = Role::CANDIDATE;
        $candidate->email_verified_at = now();
        $candidate->save();

        $company = new User;
        $company->name = 'Company One';
        $company->email = 'company1@test.com';
        $company->password = bcrypt('password');
        $company->role_id = Role::COMPANY;
        $company->email_verified_at = now();
        $company->save();

        $company = new User;
        $company->name = 'Company Two';
        $company->email = 'company2@test.com';
        $company->password = bcrypt('password');
        $company->role_id = Role::COMPANY;
        $company->email_verified_at = now();
        $company->save();
    }
}
