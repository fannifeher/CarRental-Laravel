<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    public function index()
    {
        return view('admin.reservation.reservations', [
            'reservations' => Reservation::All(),
        ]);
    }

    public function edit(Reservation $reservation)
    {
        return view('admin.reservation.edit', [
            "reservation" => $reservation,
            "cars" => Car::All()
        ]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'carId' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        
        $bookedPeriods = Reservation::where('car_id', $request->carId)
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($request) {
                $query->where('start', '<=', $request->end)
                    ->where('end', '>=', $request->start);
            })
            ->get(); 
        
            
        if ($bookedPeriods->isNotEmpty()) {
            Session::flash('error');
            return redirect()->back();
        }

        $reservation->start = $validated['start'];
        $reservation->end = $validated['end'];
        $reservation->car_id = $validated['carId'];
        $reservation->customer->name = $validated['name'];
        $reservation->customer->email = $validated['email'];
        $reservation->customer->phone = $validated['phone'];
        $reservation->customer->address = $validated['address'];
        $reservation->save();
        $reservation->customer->save();



        return redirect()->route('reservations.index');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
}
