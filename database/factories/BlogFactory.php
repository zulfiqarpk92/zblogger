<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
  protected $model = Blog::class;

  public function definition()
  {
    $images = [
        'images/DU4hLjGPEMwAgvZ28i3NhUDLDeTOX0i9AVDSMp8e.jpg',
        'images/jee5TLQFITpZkCUsKMLGnkHRo9B2HrNzLnxDXGSu.jpg',
        'images/qSkzjhVn5cnpovdOElvJP9DGKA2SjwROkdDXb3rc.jpg',
        'images/wEEPWzrqqQCgrBCaiEbz0dzBuhWPwrV837JOJrXj.jpg'
    ];
    return [
      'id'            => Blog::max('id') + 1,
      'title'         => $this->faker->sentence,
      'body'          => $this->faker->paragraphs(3, true),
      'image_path'    => $images[array_rand($images, 1)],
      'user_id'       => User::pluck('id')->random(),
      'published_at'  => Carbon::now()->subDays(rand(0, 30)),
    ];
  }
}
