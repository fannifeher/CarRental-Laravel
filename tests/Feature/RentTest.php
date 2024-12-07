<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Customer;

class RentTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        $response = $this->get('/cars');

        $response->assertViewIs('welcome');

        $response->assertViewHas('cars', []);

    }

    public function test_search_available_cars(): void
    {   
        $this->refreshApplication();
        $car1 = Car::factory()->create();
        $car2 = Car::factory()->create();
        $car3 = Car::factory()->create();

        $customer = Customer::factory()->create();

        Reservation::factory()->create([
            'car_id' => $car1->id,
            'customer_id' => $customer->id,
            'start' => '2025-03-01',
            'end' => '2025-03-05',
        ]);

        $response = $this->withSession([
            '_token' => csrf_token(),
        ])->post('/cars', [
            'start' => '2025-03-01',
            'end' => '2025-03-05',
        ]);
        $response->assertViewIs('welcome');

        $cars = $response->original->getData()['cars'];
        $this->assertCount(2, $cars); 

    }

    public function test_rent_function(): void
    {
        $car = Car::factory()->create([
            'dailyPrice' => 1000
        ]);
        $start = "2025-03-01";
        $end = "2025-03-05";
        $response = $this->get("/rent/{$car->id}/{$start}/{$end}");
        $response->assertStatus(200);
        $response->assertViewIs('rent');
        $response->assertViewHas("car", $car);
        $response->assertViewHas("start", $start);
        $response->assertViewHas("end", $end);
        $response->assertViewHas("numOfdays", 5);
        $response->assertViewHas("total", 5000);
    }

    public function test_store_function(): void
    {
        $car = Car::factory()->create();
        $customer = Customer::factory()->create();

        $start = "2025-03-01";
        $end = "2025-03-05";


        $response = $this->post(route('store', [
            'car' => $car->id, 
            'start' => $start, 
            'end' => $end,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            ]));


        $response->assertRedirect(route('index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservations', [
            'start' => $start,
            'end' => $end,
            'car_id' => $car->id,
            'customer_id' => $customer->id,
        ]);


        $this->assertDatabaseHas('customers', [
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
        ]);

        $response = $this->post(route('store', [
            'car' => $car->id, 
            'start' => $start, 
            'end' => $end,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            ]));

        $response->assertRedirect(route('index'));
        $response->assertSessionHas('error');
    }

    public function test_admin_function(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
    }
}
