<?php

use App\Models\Master\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->seed(1234);
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->company_id = 1;
            $product->product_name = $faker->word;
            $product->product_type = $faker->word;
            $product->created_by = 1;
            $product->updated_by = 1;
            $product->save();
        }
    }
}
