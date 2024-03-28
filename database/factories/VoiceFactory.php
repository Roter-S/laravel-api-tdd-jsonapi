<?php

namespace Database\Factories;

use App\Models\Instrument;
use App\Models\Voice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Voice>
 */
class VoiceFactory extends Factory
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
            'name' => $this->faker->name,
            'instrument_id' => Instrument::factory(),
        ];
    }
}
