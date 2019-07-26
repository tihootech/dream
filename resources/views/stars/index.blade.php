@extends('layouts.dashboard')

@section('title')
    <title> Stars List & Details </title>
@endsection

@section('main')

    <div class="text-center">
        <a href="{{url("details")}}" class="btn btn-secondary"> Details </a>
    </div>
    <div class="card card-body mt-3">
        @include('tables.stars')
    </div>

@endsection
