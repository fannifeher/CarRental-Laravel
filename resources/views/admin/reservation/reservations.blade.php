@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class = "table table-striped">
                            <th>start</th>
                            <th>end</th>
                            <th>car</th>
                            <th>customer name</th>
                            <th>phone number</th>
                            <th>email</th>
                            <th>address</th>
                            <th></th>
                            <th></th>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{$reservation->start}}</td>
                                    <td>{{$reservation->end}}</td>
                                    <td>{{$reservation->car->name}}</td>
                                    <td>{{$reservation->customer->name}}</td>
                                    <td>{{$reservation->customer->phone}}</td>
                                    <td>{{$reservation->customer->email}}</td>
                                    <td>{{$reservation->customer->address}}</td>
                                    <td><a role="button" class="btn btn-sm btn-primary" href="{{ route('reservations.edit', $reservation) }}">Edit</a></td>
                                    <form action="{{route('reservations.destroy', $reservation)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                        @csrf
                                        @method('DELETE')
                                        <td><button type="submit" class="btn btn-sm btn-danger">Delete</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection