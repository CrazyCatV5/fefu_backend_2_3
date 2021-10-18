<?php

namespace Database\Factories;

use App\Models\News1;
use Illuminate\Database\Eloquent\Factories\Factory;

class News1Factory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News1::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(),
            'description' => $this->faker->realText(255),
            'text' => $this->faker->realTextBetween(100, 500),
            'is_published' => $this->faker->boolean(50),
            'published_at' => $this->faker->dateTimeBetween('-2 months'),
        ];
    }
}
