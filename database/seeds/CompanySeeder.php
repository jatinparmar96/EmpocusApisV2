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
        $company->company_name = "Rokso India Pvt Ltd";
        $company->company_display_name = "Rokso Chemicals";
        $company->website = "www.rokso.com";
        $company->created_by = 1;
        $company->updated_by = 1;
        $company->save();
    }
}
