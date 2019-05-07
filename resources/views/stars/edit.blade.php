@extends('layouts.dashboard')

@section('title')
    <title> Edit Star </title>
@endsection

@section('main')
    <div class="card card-body">
        <form class="row justify-content-center" action="{{url("stars/$star->id")}}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group col-md-4">
                <label for="name"> Name </label>
                <input type="text" name="name" class="form-control form-control-lg" id="name" value="{{$star->name ?? old('name')}}">
            </div>
            <hr class="w-100">

            @foreach ($fields as $field)
                <div class="form-group col-md-3">
                    <label for="{{$field}}">{{ucfirst($field)}}</label>
                    <input type="text" name="details[{{$field}}]" value="{{$star->details->$field ?? null}}" class="form-control">
                </div>
            @endforeach

            <hr class="w-100">
            <div class="col-md-2 align-self-center">
                <button type="submit" class="btn btn-primary btn-block mt-2"> Update </button>
            </div>

        </form>
    </div>
@endsection
