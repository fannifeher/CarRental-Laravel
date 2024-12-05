<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ReservationController;
use App\Http\Middleware\IsAdmin;

//Auth::routes();

Route::get('/', function () {
    return redirect('/cars');
});

Route::get('/cars',  [RentController::class, 'index'])->name('index');

Route::post('/cars',  [RentController::class, 'search'])->name('search');

Route::get('/rent/{car}/{start}/{end}',  [RentController::class, 'rent'])->name('rent');

Route::post('/store/{car}/{start}/{end}', [RentController::class, 'store'])->name('store');

Route::get('/admin',  [RentController::class, 'admin'])->name('admin')->middleware(IsAdmin::class);

Route::resource('admin/reservations', ReservationController::class)->only(['index', 'edit', 'update', 'destroy'])->middleware(IsAdmin::class);

Route::resource('admin/cars', CarController::class)->only(['index', 'create', 'store', 'edit', 'update'])->middleware(IsAdmin::class);

Route::post('admin/cars/{car}/deactivate', [CarController::class, 'deactivate'])->name('cars.deactivate')->middleware(IsAdmin::class);

Route::fallback(function () {
    return abort(404);
});

