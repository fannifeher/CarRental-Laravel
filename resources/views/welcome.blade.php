@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                        <h2 class="text-center">Rent a car</h2>
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                Successfull reservation!
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-success">
                                Failed reservation! Please try again!
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <h3>Choose the date</h3>
                                <form method="POST" action="{{ route('search') }}">
                                    @csrf
                                    <label for="start">From:</label>
                                    <input type="date" id="start" name="start" value="{{ old('start', isset($start) ? $start : '') }}"  class="form-control @error('start') is-invalid @enderror">
                                    @error('start')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="end">To:</label>
                                    <input type="date" id="end" name="end" value="{{ old('end', isset($end) ? $end : '') }}" class="form-control @error('end') is-invalid @enderror"> 
                                    @error('end')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <br>
                                    <button type="submit" class="btn btn-primary"> Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="row">
                            @foreach ($cars as $car)
                                <div class="col-md-6 col-sm-12 col-lg-4">
                                    <div class="card" style="width: 100%; display: flex; flex-direction: column; height: 100%;" >
                                        <img class="card-img-top"  src="{{ isset($car['cover_image_path']) ? $car['cover_image_path'] : asset('images/default.jpg') }}"  >
                                        <div class="card-body">
                                        <h5 class="card-title">{{$car->name}}</h5>
                                        <p class="card-text">{{$car->description}}</p>
                                        {{$car->dailyPrice}} Ft/day
                                        <a href="{{ route('rent', ['car' => $car, 'start' => $start, 'end' => $end]) }}" class="btn btn-primary">Rent</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
