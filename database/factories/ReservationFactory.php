<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numOfDays = fake()->numberBetween(0, 25);
        $start = fake()->dateTimeBetween('-1 day ','+3 month');
        $end = Carbon::instance($start)->addDays($numOfDays);
        return [
            'start' => $start,
            'end' => $end,
        ];
    }
}
