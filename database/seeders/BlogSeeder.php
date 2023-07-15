<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user_ids = User::pluck('id');
        for ($i = 0; $i < 50; $i++) {
            Blog::create([
                'id'          => Blog::max('id') + 1,
                'title'       => $faker->sentence,
                'body'        => $faker->paragraphs(3, true),
                'image_path'  => 'images/bKwjQekk3k2VTIAAMZFN8wwvGPHrXh1fJZRUH9sL.jpg',
                'user_id'     => $user_ids->random(),
                'published_at'=> Carbon::now()
            ]);
        }
    }
}
