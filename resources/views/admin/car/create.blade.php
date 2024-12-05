@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name*</label>
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
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" >{{ old('description')}}</textarea>
                @error("description")
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        
        <div class="form-group row mb-3">
            <label for="dailyPrice" class="col-sm-2 col-form-label">Daily Price*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control  @error("dailyPrice") is-invalid @enderror" id="dailyPrice"
                    name="dailyPrice" value="{{ old("dailyPrice") }}">
                @error("dailyPrice")
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div> 
            
            
        <div class="form-group row mb-3">
            <label for="cover_image" class="col-sm-2 col-form-label">Cover image*</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="file" class="form-control-file @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image">
                            @error('cover_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary"> Store</button>
        </div>
    </form>
    </div>
</div>
@endsection
