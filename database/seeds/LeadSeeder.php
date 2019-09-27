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
        for ($i = 0; $i < 100; $i++) {
            $lead = new Lead();
            $lead->company_id = 1;
            $lead->company_name = $faker->domainName();
            $lead->source = $faker->randomElement(['web', 'email']);
            $lead->assigned_to = ['id' => $faker->numberBetween(1, 50)];
            $lead->lead_status = $faker->randomElement(['new', 'contacted', 'interested', 'demo', 'under_review', 'unqualified']);
            $lead->product = ['id' => $faker->numberBetween(1, 9)];


            $lead->company_info = [
                "company_employee_number" => $faker->numberBetween(10, 100),
                "company_annual_revenue" => $faker->numberBetween(1000, 10000),
                "company_website" => $faker->domainName,
                "company_phone" => $faker->phoneNumber,
                "company_industry_type" => $faker->randomElement([
                    'Defence',
                    'Education',
                    'Engineering',
                    'Investment Banking',
                    'Newspaper Publishing',
                    'Online Auctions',
                    'Retail & Wholesale',
                    'Telecommunication',
                ]),
                "company_business_type" => $faker->randomElement([
                    'Analyst',
                    'Competitor',
                    'Customer',
                    'Integration',
                    'Investor',
                    'Partner',
                    'Press',
                    'Prospect',
                ]),
            ];
            $lead->social = [
                "facebook_link" => "/bitmanity",
                "twitter_link" => "/twitter",
                "linkedin_link" => "/linked_in"
            ];
            $lead->source_info = [
                "campaign" => "Campaign 1",
                "medium" => "Field Visit",
                "keyword" => "None"
            ];
            $lead->deal = [
                "deal_name" => "",
                "deal_value" => "",
                "deal_expected_close_date" => "",
                "deal_product" => ""
            ];

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
                    "email" => $faker->email,
                    "designation" => "Co-Founder",
                    "primary_contact_number" => $faker->phoneNumber,
                    "secondary_contact_number" => $faker->phoneNumber
                ]
            ];
            $address = [
                "address_line_1" => $faker->streetAddress,
                "address_line_2" => $faker->streetAddress,
                "city" => $faker->city,
                "state" => $faker->name(),
                "pincode" => $faker->randomNumber(),
                "meta" => "defaultAddress",
            ];
            $lead->created_by = 1;
            $lead->updated_by = 1;
            $lead->save();
            $lead->contacts()->createMany($contact_persons);
            $lead->address()->create($address);
        }
    }
}
