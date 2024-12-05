<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Car;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $customers = Customer::factory(5)->create();
        $cars = Car::factory(10)->create();

        foreach ($cars as $car) {
            Reservation::factory(1)->create()->each(function ($reservation) use ($customers, $car) {
                $reservation->customer()->associate($customers->random())->save();
                $reservation->car()->associate($car)->save();
            });
        }
    }
}
