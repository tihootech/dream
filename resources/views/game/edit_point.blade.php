@extends('layouts.dashboard')

@section('title')
    <title> Edit A Point </title>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <h3> Editing A Point </h3>
            <p> Please enter correct amount of points </p>
        </div>
        <div class="card-body">
            <form class="row" action="{{url("points/$point->id/edit")}}" method="get">
                @csrf

                <div class="form-group col-md-3 ml-auto">
                    <input type="number" name="new_amount" value="{{$point->amount}}" class="form-control form-control-lg">
                </div>
                <div class="form-group col-md-2 mr-auto">
                    <button type="submit" class="btn btn-primary"> Update Point </button>
                </div>

            </form>
        </div>
    </div>
@endsection
