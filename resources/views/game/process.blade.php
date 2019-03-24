@extends('layouts.dashboard')

@section('title')
    <title> Process </title>
@endsection

@section('main')
    <div class="card card-body">
        <form class="row justify-content-center" action="{{url("next_month")}}" method="post">
            @csrf

            <div class="form-group col-md-3">
                <label for="best-girl"> Best Girl Of The Month </label>
                <input type="text" id="best-girl" name="best_girl" value="{{old('best_girl')}}" class="form-control form-control-lg">
            </div>
            <div class="form-group col-md-3">
                <label for="best-night"> Best Night Of The Month </label>
                <input type="text" id="best-night" name="best_night" value="{{old('best_night')}}" class="form-control form-control-lg">
            </div>
            <div class="form-group align-self-end col-md-2">
                <button type="submit" class="btn btn-primary"> Next Month </button>
            </div>

        </form>
    </div>
@endsection
