<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
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
            $task = new \App\Models\Crm\Task();
            $task->title = $faker->title;
            $task->due_date = [
                'year' => $faker->year,
                'month' => $faker->month,
                'day' => $faker->numberBetween(1, 28)
            ];
            $task->description = $faker->text;
            $task->lead_id = $faker->numberBetween(1, 20);
            $task->is_done = false;

            $task->created_by = $faker->numberBetween(1, 9);
            $task->updated_by = $task->created_by;
            $task->save();
        }


    }
}
