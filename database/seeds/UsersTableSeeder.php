<?php

use Illuminate\Database\Seeder;
use \Faker\Factory as Factory;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Let's clear the users table first
      User::truncate();

      $faker = Factory::create();

      // Let's make sure everyone has the same password and
      // let's hash it before the loop, or else our seeder
      // will be too slow.
      $password = Hash::make('admin');

      User::create([
          'name' => 'admin',
          'email' => 'admin@email.com',
          'password' => $password,
      ]);

      // And now let's generate a few dozen users for our app:
      for ($i = 0; $i < 50; $i++) {
          User::create([
              'name' => $faker->name,
              'email' => $faker->email,
              'password' => $password,
          ]);
      }
    }
}
