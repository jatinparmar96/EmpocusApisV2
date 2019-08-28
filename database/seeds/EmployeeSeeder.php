<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->seed();
        $employees = collect();
        for ($i = 0; $i < 10000; $i++) {
            $employee = new \App\Models\Master\Employee();
            $employee->company_id = 1;
            $employee->employee_name = $faker->name;
            $employee->employee_username = $faker->unique()->userName;
            $employee->employee_adhaar_number = $faker->randomNumber();
            $employee->employee_pan_number = $faker->randomNumber();
            $employee->employee_contact_numbers = [['contact_number'=>$faker->phoneNumber]];
            $employee->email = $faker->email;
            $employee->bank_name = $faker->word;
            $employee->bank_account_number = $faker->bankAccountNumber;
            $employee->ifsc_code = $faker->randomNumber();
            $employee->provident_fund_account_number = $faker->randomNumber();
            $employee->created_by = 1;
            $employee->updated_by = 1;
            $employee->save();
            $residentialAddress = new \App\Models\Master\Address();
            $residentialAddress->address_line_1 = $faker->streetAddress;
            $residentialAddress->address_line_2= $faker->address;
            $residentialAddress->city = $faker->city;
            $residentialAddress->state =$faker->city;
            $residentialAddress->pincode = $faker->randomNumber();
//            $residentialAddress->country = $faker->country;
            $residentialAddress->meta = "ResidentialAddress";
            $employee->residential_address()->save($residentialAddress);
            $permanentAddress = new \App\Models\Master\Address();
            $permanentAddress->address_line_1 = $faker->streetAddress;
            $permanentAddress->address_line_2= $faker->address;
            $permanentAddress->city = $faker->city;
            $permanentAddress->state =$faker->city;
            $permanentAddress->pincode = $faker->randomNumber();

//            $permanentAddress->country = $faker->country;
            $permanentAddress->meta = "PermanentAddress";
            $employee->permanent_address()->save($permanentAddress);



            //   $employees->push($employee);
        }
//        $coll = $employees->chunk(500);
//        foreach ($coll as $chunk)
//        {
//            \Illuminate\Support\Facades\DB::table('employees')->insert($chunk->toArray());
//        }

    }
}
