@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{route('cars.index')}}" class="btn btn-primary">
                    Cars
                </a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{route('reservations.index')}}" class="btn btn-primary">
                     Reservations
                </a>
            </div>
        </div>
    </div>
@endsection