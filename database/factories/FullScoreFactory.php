<?php

namespace Database\Factories;

use App\Models\FullScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FullScore>
 */
class FullScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'composer' => $this->faker->name,
            'year' => $this->faker->year,
        ];
    }
}
