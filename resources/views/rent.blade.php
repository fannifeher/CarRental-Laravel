@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Fill this form to rent the chosen car!</h1>
    <form method="POST" action="{{ route('store', ['car' => $car, 'start' => $start, 'end' => $end]) }}">
        @csrf
        <div class="container d-flex justify-content-center">
            <div class="col-md-6 col-sm-12 col-lg-3">
                <div class="card center " style="width: 100%;" >
                    <img class="card-img-top"  src="{{ isset($car['cover_image_path']) ? $car['cover_image_path'] : asset('images/default.jpg') }}"  >
                    <div class="card-body">
                    <h5 class="card-title">{{$car->name}}</h5>
                    <p class="card-text">{{$car->description}}</p>
                    <h5>{{"From " . $start}}</h5>
                    <h5> {{" To " . $end}} </h5>
                    {{$car->dailyPrice}} Ft/day <br>
                    {{$numOfdays}} days <br>
                    Total: {{$total}} Ft
                    </div>
                </div>
            </div>
        </div><br>
        
        <div class="form-group row mb-3">
            <label for="Name" class="col-sm-2 col-form-label">Name*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ old('name') }}">
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
                    name="email" value="{{ old('email') }}">
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
                    name="address" value="{{ old('address') }}">
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
                    name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary"> Submit</button>
        </div>
    </form>
    </div>
@endsection