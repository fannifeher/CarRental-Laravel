<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class CarController extends Controller
{
    public function index()
    {
        return view('admin.car.cars', [
            'cars' => Car::All(),
        ]);
    }

    public function create()
    {
        return view('admin.car.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:cars|required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'required|file|mimes:jpg,png|max:2048',
            'dailyPrice' => 'required|numeric'
            
        ]);

        $cover_image_path = '';
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_images/cover_image_'.Str::random(10).'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->put($cover_image_path,$file->get());
        }

        $room = Car::factory()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'dailyPrice' => $validated['dailyPrice'],
            'cover_image_path' => $cover_image_path,

        ]);
        Session::flash('car_created');
    
        return redirect()->route('cars.create');
    }


    public function edit(Car $car)
    {
        return view('admin.car.edit', [
            "car" => $car,
        ]);
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cars,name,' . $car->id,
            'description' => 'nullable|string',
            'cover_image' => 'file|mimes:jpg,png|max:2048',
            'dailyPrice' => 'required|numeric'
            
        ]);

        $cover_image_path = '';
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_images/cover_image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($cover_image_path, file_get_contents($file));
            if ($car->cover_image_path) {
                Storage::disk('public')->delete($car->cover_image_path);
            }
            $car->cover_image_path = $cover_image_path;}

        

        $car->name = $validated['name'];
        $car->description = $validated['description'];
        $car->dailyPrice = $validated['dailyPrice'];
        $car->save();

        Session::flash('car_updated');
    
        return redirect()->route('cars.index');
    }

    public function deactivate(Car $car)
    {
        if($car->active)
        {
            $car->active = false;
            $car->save();

            $count = Reservation::Where('car_id', $car->id)->count();
            Reservation::Where('car_id', $car->id)->delete();
            Session::flash("deactivated");
            Session::flash('count', $count);
            return redirect()->route('cars.index');
        }
        else
        {
            $car->active = true;
            $car->save();
            return redirect()->route('cars.index');
        }
             

    }
}
