<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

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
            'is_published' => $this->faker->boolean(70),
            'published_at' => $this->faker->dateTimeBetween('-2 months'),
        ];
    }
}
