<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder_Company_User_Auth extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_auth = new UserAuthsTableSeeder();
        $user_auth->run();

        $company = new CompaniesTableSeeder();
        $company->run();
    }
}
