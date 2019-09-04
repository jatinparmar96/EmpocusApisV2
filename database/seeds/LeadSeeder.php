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
        $lead = new Lead();
        $lead->company_name = $faker->realText();
        $lead->source = $faker->randomElement(['web', 'email']);
        $lead->assigned_to = ['id' => $faker->numberBetween(1, 999)];
        $lead->lead_status = $faker->randomElement(['new', 'contacted', 'interested', 'demo', 'under_review', 'unqualified']);
        $lead->product = ['id' => $faker->numberBetween(1, 9)];

        $lead->scontact_personsource = [
            [
                "name" => $faker->name(),
                "email" => $faker->email,
                "designation" => "Co-Founder",
                "primary_contact_number" => $faker->phoneNumber,
                "secondary_contact_number" => $faker->phoneNumber
            ]
        ];
        $lead->source = $faker->randomElement(['web', 'email']);
        $lead->source = $faker->randomElement(['web', 'email']);
        $lead->source = $faker->randomElement(['web', 'email']);
        $lead->source = $faker->randomElement(['web', 'email']);
    }
}
