<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPokemon>
 */
class UserPokemonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pokemon' => fake()->firstName(),
            'type' => fake()->randomElement(['favorite', 'like', 'hate']),
            'user_id' => User::all()->random()->id
        ];
    }
}
