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
    return [
      'id'            => Blog::max('id') + 1,
      'title'         => $this->faker->sentence,
      'body'          => $this->faker->paragraphs(3, true),
      'image_path'    => 'images/442SscGn4UYOdv6unOtXM8q2iFLbpYTk2hoaQSlc.jpg',
      'user_id'       => User::pluck('id')->random(),
      'published_at'  => Carbon::now()->subDays(rand(0, 30)),
    ];
  }
}
