<?php

use Illuminate\Database\Seeder;
use \Faker\Factory as Factory;
use App\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Let's truncate our existing records to start from scratch.
     Article::truncate();

     $faker = Factory::create();

     // And now, let's create a few articles in our database:
     for ($i = 0; $i < 50; $i++) {
          Article::create([
             'title' => $faker->sentence,
             'body' => $faker->paragraph,
             'image' => $faker->imageUrl(640, 480, 'cats'),
             'author' => $faker->firstNameMale.' '.$faker->lastName ,
             'published_at' => $faker->date('d/m/Y','now'),
         ]);
     }

    }
}
