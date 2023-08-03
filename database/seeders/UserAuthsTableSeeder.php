<?php

namespace Database\Seeders;

use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAuthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_auths = array(
            [
                'name' => 'Super Admin',
                'is_system_owner' => true,
            ],
            [
                'name' => 'Admin',
                'is_system_owner' => true,
            ],
            [
                'name' => 'Staff',
                'is_system_owner' => true,
            ],
            // Non System Owner
            [
                'name' => 'Company Admin',
                'is_system_owner' => false,
            ],
            [
                'name' => 'Company Staff',
                'is_system_owner' => false,
            ],
        );

        DB::table('user_auths')->insert($user_auths);

    }
}
