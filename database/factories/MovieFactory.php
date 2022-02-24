<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'movie_id' => $this->faker->randomDigit,
            'favorite' => $this->faker->randomElement($array = array ('YES','NO')),
            'created_at' => now(),

        ];
    }
}
