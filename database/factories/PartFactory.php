<?php

namespace Database\Factories;

use App\Models\FullScore;
use App\Models\Instrument;
use App\Models\Part;
use App\Models\Voice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Part>
 */
class PartFactory extends Factory
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
            'url' => $this->faker->url,
            'instrument_id' => Instrument::factory(),
            'voice_id' => Voice::factory(),
            'full_score_id' => FullScore::factory(),
        ];
    }
}
