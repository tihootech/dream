@extends('layouts.dashboard')

@section('title')
    <title> Stars List & Details </title>
@endsection

@section('main')

    <div class="card card-body">
        @include('tables.stars')
    </div>

@endsection
