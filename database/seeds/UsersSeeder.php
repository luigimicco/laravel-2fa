<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $new_user = new User();
        $new_user->name = 'admin';
        $new_user->email = 'admin@webapp.it';
        $new_user->password = bcrypt('password');
        $new_user->save();


    }
}


// $new_user->roles()-attach(Arr::random($roles_ids, rand(1, count($roles_ids)))); 
// 