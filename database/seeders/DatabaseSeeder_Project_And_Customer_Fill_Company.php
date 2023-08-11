<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder_Project_And_Customer_Fill_Company extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $company_id = Company::all()->pluck('id')->toArray();

        foreach ($projects as $project) {
            if(empty($project->company_id)) {
                $project->company_id = $company_id[array_rand($company_id, 1)];
                $project->save();
            }
        }

        $customers = Customer::all();

        foreach ($customers as $customer) {
            $customer->company_id = $company_id[array_rand($company_id, 1)];
            $customer->save();
        }
    }
}
