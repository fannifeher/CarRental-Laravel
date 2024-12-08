@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class = "text-center">Edit reservation</h1>
        <form method="POST" action="{{ route('reservations.update', $reservation) }}">
            @csrf
            @method('PUT')
            <div class="form-group row mb-3">
                <label for="start" class="col-sm-2 col-form-label">From*</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control  @error('start') is-invalid @enderror" id="start"
                        name="start" value="{{ old('start', $previousStart) }}">
                    @error('start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="end" class="col-sm-2 col-form-label">To*</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control  @error('end') is-invalid @enderror" id="end"
                        name="end" value="{{ old('end', $previousEnd) }}">
                    @error('end')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="carId" class="col-sm-2 col-form-label">Car*</label>
                <div class="col-sm-10">
                    <select name="carId" id="carId">
                        @foreach ($cars as $car)
                            <option
                                value="{{ $car->id }}"{{ old('carName', $reservation->car->id) == $car->id ? 'selected' : '' }}>
                                {{ $car->name }}</option>
                        @endforeach
                    </select>
                    @error('carId')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="Name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $reservation->customer->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="Email" class="col-sm-2 col-form-label">Email*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $reservation->customer->email) }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="Address" class="col-sm-2 col-form-label">Address*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ old('address', $reservation->customer->address) }}">
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="Phone" class="col-sm-2 col-form-label">Phone*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', $reservation->customer->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Store</button>
            </div>
        </form>
    </div>
    </div>
@endsection
