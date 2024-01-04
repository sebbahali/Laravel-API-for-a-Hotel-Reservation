<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'images'=>fake()->image(),
            'adults'=>fake()->randomNumber(),
            'children'=>fake()->randomNumber(),
            'is_booked'=> 0,
         'hotel_id'=> Hotel::inRandomOrder()->value('id'),
           
            'price'=>fake()->randomDigit(),
        ];
    }
}
