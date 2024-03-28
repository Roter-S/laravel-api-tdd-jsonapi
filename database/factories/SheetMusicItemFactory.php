<?php

namespace Database\Factories;

use App\Models\FullScore;
use App\Models\SheetMusicItem;
use App\Models\SheetMusicList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SheetMusicItem>
 */
class SheetMusicItemFactory extends Factory
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
            'position' => $this->faker->numberBetween(1, 10),
            'sheet_music_list_id' => SheetMusicList::factory(),
            'full_score_id' => FullScore::factory(),
        ];
    }
}
