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
            <form class="row justify-content-center" action="{{url("points/$point->id/edit")}}" method="get">
                @csrf
                <input type="hidden" name="update" value="1">

                <div class="form-group col-md-3">
                    <label>Amount</label>
                    <input type="number" name="new_amount" value="{{$point->amount}}" class="form-control form-control-lg">
                </div>
                <div class="form-group col-md-3">
                    <label>Type</label>
                    <input type="text" name="new_type" value="{{$point->type}}" class="form-control form-control-lg">
                </div>
                <div class="w-100"></div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary btn-block"> Update Point </button>
                </div>

            </form>
        </div>
    </div>
@endsection
