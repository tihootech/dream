@extends('layouts.dashboard')

@section('title')
    <title> Possible Stars </title>
@endsection

@section('main')
    <div class="card card-body">
        <form class="row" action="{{url("stars/$star->id")}}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group col-md-4 ml-auto">
                <label for="name"> Name </label>
                <input type="text" name="name" class="form-control form-control-lg" id="name" value="{{$star->name ?? old('name')}}">
            </div>

            <div class="col-md-2 mr-auto align-self-center">
                <button type="submit" class="btn btn-primary btn-block mt-2"> Update </button>
            </div>

        </form>
    </div>
@endsection
