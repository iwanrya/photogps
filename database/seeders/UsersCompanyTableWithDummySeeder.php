<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersCompanyTableWithDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company_ids = Company::where('is_system_owner', false)->pluck('id')->toArray();
        $user_ids = User::all()->pluck('id')->toArray();

        $auth = [4, 5];

        $company_index = 1;
        $auth_index = 1;

        foreach ($user_ids as $user_id) {
            $company_users = CompanyUser::where('user_id', $user_id)->get()->toArray();

            if (empty($company_users)) {

                CompanyUser::create([
                    'user_id' => $user_id,
                    'company_id' => $company_ids[($company_index-1) % count($company_ids)],
                    'auth' => $auth[($auth_index-1) % count($auth)],
                ]);

                if ($auth_index % 2 == 0) {
                    $company_index++;
                }
                $auth_index++;
            } else {

            }
        }
    }
}
