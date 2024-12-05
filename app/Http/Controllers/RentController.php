<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;

class RentController extends Controller
{

    public function index()
    {
        return view('welcome', [
            'cars' => [],
        ]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'start' => 'required|date|after:today',
            'end' => 'required|date|after_or_equal:start',
            
        ]);

        $booked = Reservation::where(function ($query) use ($validated) {
            $query->where('start', '<=', $validated['end'])
                  ->where('end', '>=', $validated['start']);
        })->get();
        
        return view('welcome', [
            'cars' => Car::where('active', true)->whereNotIn('id', $booked->pluck('car_id'))->get(),
            'start' => $validated['start'],
            'end' => $validated['end']
        ]);
    }

    public function rent(Car $car, $start, $end)
    {
        $booked = Reservation::where(function ($query) use ($start, $end, $car) {
            $query->where('start', '<=', $end)
                  ->where('end', '>=', $start)
                  ->where('car_id', $car->id);
        })->first();
        if($booked)
        {
            Session::flash('error');
            return redirect()->route('index');
        }
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $numOfdays = $startDate->diffInDays($endDate, false) + 1;
        $total = $numOfdays * $car->dailyPrice;
        return view('rent', [
            'car' => $car,
            'start' => $start,
            'end' => $end,
            'numOfdays' => $numOfdays,
            'total' => $total
            
        ]);
    }

    public function store(Request $request, Car $car,  $start, $end)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            
        ]);



        
        $booked = Reservation::where(function ($query) use ($start, $end, $car) {
            $query->where('start', '<=', $end)
                  ->where('end', '>=', $start)
                  ->where('car_id', $car->id);
        })->first();
        if($booked)
        {
            Session::flash('error');
            return redirect()->route('index');
        }
        else
        {
            
            $existingCustomer = Customer::where('name', $validated['name'])
                ->where('phone', $validated['phone'])
                ->where('email', $validated['email'])
                ->where('address', $validated['address'])->first();
            if(!$existingCustomer)
            {
                $existingCustomer = Customer::factory()->create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address']
        
                ]);
            }

        
            Reservation::factory()->create([
                'start' => $start,
                'end' => $end,
                'customer_id' => $existingCustomer->id,
                'car_id' => $car->id
                ]);

            Session::flash('success');
            return redirect()->route('index');
        }
        
            
    }

    public function admin()
    {
        return view('admin.index');
    }
    
}
