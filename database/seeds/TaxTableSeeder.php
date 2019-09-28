<?php

use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = [0,5,8,12,18,28];
        foreach($taxes as $tax){
            $taxModel = new \App\Models\Tax();
            $taxModel->company_id=1;
            $taxModel->tax_rate=$tax;
            $taxModel->tax_name="GST ".$tax."%";
            $taxModel->save();
        }
    }
}
