<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Auth::routes();

Route::get('/', function () {
    return redirect('/cars');
});

Route::get('/cars',  [CarController::class, 'index'])->name('index');

Route::post('/cars',  [CarController::class, 'search'])->name('search');

Route::get('/rent/{car}/{start}/{end}',  [CarController::class, 'rent'])->name('rent');

Route::post('/store/{car}/{start}/{end}', [CarController::class, 'store'])->name('store');



