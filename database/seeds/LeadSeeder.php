<?php

use App\Models\Crm\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i<100;$i++)
        {
            $lead = new Lead();
            $lead->company_id = 1;
            $lead->company_name = $faker->domainName();
            $lead->source = $faker->randomElement(['web', 'email']);
            $lead->assigned_to = ['id' => $faker->numberBetween(1, 999)];
            $lead->lead_status = $faker->randomElement(['new', 'contacted', 'interested', 'demo', 'under_review', 'unqualified']);
            $lead->product = ['id' => $faker->numberBetween(1, 9)];

            $contact_persons = [
                [
                    "name" => $faker->name(),
                    "email" => $faker->email,
                    "designation" => "Co-Founder",
                    "primary_contact_number" => $faker->phoneNumber,
                    "secondary_contact_number" => $faker->phoneNumber
                ],
                [
                    "name" => $faker->name(),
                    "email  " => $faker->email,
                    "designation" => "Co-Founder",
                    "primary_contact_number" => $faker->phoneNumber,
                    "secondary_contact_number" => $faker->phoneNumber
                ]
            ];
            $lead->created_by = 1;
            $lead->updated_by = 1;
            $lead->save();
            $lead->contacts()->createMany($contact_persons);
        }



    }
}
