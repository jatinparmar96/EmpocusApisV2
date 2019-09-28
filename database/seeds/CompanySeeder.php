<?php

use App\Models\Master\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = new Company();
        $company->user_id = 1;
        $company->name = "Rokso India Pvt Ltd";
        $company->display_name = "Rokso Chemicals";
        $company->website = "www.rokso.com";
        $company->created_by_id = 1;
        $company->updated_by_id = 1;
        $company->save();
    }
}
