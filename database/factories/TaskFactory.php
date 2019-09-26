<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Crm\Task::class, function (Faker\Generator $faker) {
    return [
        'task_type' => $faker->randomElement(['calling', 'meeting', 'follow_up', 'send_quotation', 'order_generated']),
        'due_date' => ['year' => $faker->year, 'month' => $faker->month, 'day' => $faker->numberBetween(1, 28)],
        'description' => $faker->text,
        'is_done' => 0,
        'lead_id' => \App\Models\Crm\Lead::inRandomOrder()->first()->id,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
