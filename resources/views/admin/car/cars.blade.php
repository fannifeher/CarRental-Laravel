@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-container">
                        <h1 class="text-center">Cars</h1>
                        @if (Session::has('deactivated'))
                        <div class="alert alert-success">Car deactivated
                            {{ session('count') }} reservations deleted
                        </div>
                    @endif
                        <a  href="{{route('cars.create')}}" role="button" class="btn btn-sm btn-success mb-1">New Car</a>
                        <div class="row">
                            @foreach ($cars as $car)
                                <div class="col-md-6 col-sm-12 col-lg-4">
                                    <div class="card" style="width: 100%; display: flex; flex-direction: column; height: 100%;" >
                                        <img class="card-img-top"  src="{{ isset($car['cover_image_path']) ? asset('storage/'.$car["cover_image_path"]) : asset('images/default.jpg') }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$car->name}}</h5>
                                            <p class="card-text">{{$car->description}}</p>
                                            {{$car->dailyPrice}} Ft/day <br>
                                            <div class="d-flex align-items-center">
                                                <a role="button" class="btn btn-sm btn-primary me-2" href="{{ route('cars.edit', $car) }}">Edit</a>
                                                @if ($car->active)
                                                    <form action="{{ route('cars.deactivate', $car) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to deactivate this car?');">
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger" type="submit">Deactivate</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('cars.deactivate', $car) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-secondary" type="submit">Activate</button>
                                                    </form>
                                                @endif
                                            </div>
                                            
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
