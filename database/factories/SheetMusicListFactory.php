<?php

namespace Database\Factories;

use App\Models\Outfit;
use App\Models\SheetMusicList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SheetMusicList>
 */
class SheetMusicListFactory extends Factory
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
            'annotation' => $this->faker->text,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'outfit_id' => Outfit::factory(),
        ];
    }
}
