<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = array(
            ['name' => 'SGMT', 'create_user_id' => 1, 'is_system_owner' => true],
            ['name' => 'Nakamura', 'create_user_id' => 1, 'is_system_owner' => true],
        );

        $companies = array_merge($companies, Company::factory(5)->make());

        DB::table('companies')->insert($companies);

        $company_users = array(
            ['company_id' => 1, 'user_id' => 1, 'auth' => 1],
            ['company_id' => 1, 'user_id' => 2, 'auth' => 2],
            ['company_id' => 1, 'user_id' => 3, 'auth' => 3],
        );


        DB::table('company_users')->insert($company_users);
    }
}
