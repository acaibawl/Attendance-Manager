<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => User::factory(),
        'is_over_next_day' => $this->faker->boolean(),
        'date' => $this->faker->date(),
        'start' => $this->faker->time(),
        'end' => $this->faker->time(),
        ];
    }
}
