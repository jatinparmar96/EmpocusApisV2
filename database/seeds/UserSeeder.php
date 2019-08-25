<?php

use App\Models\Master\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Jatin Parmar";
        $user->display_name = "Jatin Parmar";
        $user->email = "jatinparmar96@gmail.com";
        $user->mobile = "9028605003";
        $user->password = bcrypt("123");
        $user->save();
    }
}
