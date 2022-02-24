<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WatchlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => '1',
            'movie_id' => $this->faker->randomDigit,
            'name' => $this->faker->name,
            'is_watched' => $this->faker->randomElement($array = array ('YES','NO')),
            'created_at' => now(),

        ];
    }
}
