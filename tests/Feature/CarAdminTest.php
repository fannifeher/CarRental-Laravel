<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Customer;

class CarAdminTest extends TestCase
{

    use RefreshDatabase;

    public function test_admin_car_index(): void
    {
        $car1 = Car::factory()->create();

        $response = $this->get('/admin/cars');

        $response->assertStatus(200);

        $response->assertViewIs('admin.car.cars');

        $response->assertViewHas('cars');

    }

    public function test_admin_create_car(): void
    {
        $response = $this->get('/admin/cars/create');

        $response->assertStatus(200);

        $response->assertViewIs('admin.car.create');
    }

    public function test_admin_store_car(): void
    {
        $response = $this->post(route('cars.store'), [
            'name' => '',
            'cover_image' => null,
            'dailyPrice' => '']);
        $response->assertSessionHasErrors(['name', 'cover_image', 'dailyPrice']);
    }

    public function test_admin_car_edit_view(): void
    {
        $car = Car::factory()->create();

        $response = $this->get(route('cars.edit', $car));

        $response->assertStatus(200);

        $response->assertViewIs('admin.car.edit');

        $response->assertViewHas('car', $car);

    }
    
    public function test_admin_update_car(): void
    {
        $car = Car::factory()->create();
        $response = $this->put(route('cars.update', $car), [
                    'name' => 'car name',
                    'description' => null,
                    'dailyPrice' => 1000,]);
        $response->assertSessionHas('car_updated');
        
        $car->refresh();
        $this->assertEquals('car name', $car->name);
        $this->assertEquals(1000, $car->dailyPrice);

    }

    public function test_admin_deactivate_car(): void
    {
        $car = Car::factory()->create(['active' => true]);
        $customer = Customer::factory()->create();
        $reservation = Reservation::factory()->create([
            'car_id' => $car->id,
            'customer_id' => $customer->id]);

        $response = $this->post(route('cars.deactivate', $car));;
        $car->refresh();

        $this->assertEquals(0, $car->active);

        $this->assertCount(0, Reservation::where('car_id', $car->id)->get());
        
         $response->assertSessionHas('deactivated');

         $this->assertEquals(1, session('count'));
    }
    
}
