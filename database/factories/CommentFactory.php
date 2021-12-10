<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->realTextBetween(10, 250),
            'user_id' => $this->faker->randomElement(User::query()->pluck('id')),
            'post_id' => $this->faker->randomElement(Post::query()->pluck('id')),
            'created_at' => $this->faker->dateTimeBetween('-1 week'),
            ];
    }
}
