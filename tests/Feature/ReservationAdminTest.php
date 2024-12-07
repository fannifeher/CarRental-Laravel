<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Customer;

class ReservationAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_admin_index(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $reservation = Reservation::factory()->create([
            "car_id" => $car->id,
            "customer_id" => $customer->id,
        ]);

        $response = $this->get(route('reservations.index'));

        $response->assertStatus(200);

        $response->assertViewHas('reservations');
    }

    public function test_reservation_admin_edit_view(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $reservation = Reservation::factory()->create([
            "car_id" => $car->id,
            "customer_id" => $customer->id,
        ]);

        $response = $this->get(route('reservations.edit', $reservation));

        $response->assertStatus(200);

        $response->assertViewHas('reservation', $reservation);

        $response->assertViewHas('cars');
    }

    public function test_reservation_admin_update(): void
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();
        $newCar = Car::factory()->create();
        $reservation = Reservation::factory()->create([
            "start" => "2025-03-01",
            "end" => "2025-03-05", 
            "car_id" => $car->id,
            "customer_id" => $customer->id,
        ]);
        $response = $this->put(route('reservations.update', $reservation), [
            'start' => "2025-03-01",
            'end' => "2025-03-06", 
            'carId' => $newCar->id,
            'name' => 'name',
            'email' => "email@email.com",
            'phone' => '123456789',
            'address' => 'address']);
        
        $reservation->refresh();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'start' => '2025-03-01',
            'end' => '2025-03-06',
            'car_id' => $newCar->id,
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'name',
            'email' => "email@email.com",
            'phone' => '123456789',
            'address' => 'address',
        ]);
        
        $response->assertRedirect(route('reservations.index'));
    }

    public function test_reservation_admin_delete() : void
    {
        $reservation = Reservation::factory()->create();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
        ]);
        $response = $this->delete(route('reservations.destroy', $reservation));
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
        $response->assertRedirect(route('reservations.index'));
    }
    
}
