<?php

namespace Database\Factories;

use App\Models\Instrument;
use App\Models\User;
use App\Models\Voice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected static ?bool $status;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'date_of_birth' => $this->faker->date(),
            'phone_number' => $this->faker->phoneNumber(),
            'status' => static::$status ??= $this->faker->boolean(),
            'roles' => $this->faker->randomElement(['admin', 'user']),
            'remember_token' => Str::random(10),
            'instrument_id' => null,
            'voice_id' => null,
            'entity_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
