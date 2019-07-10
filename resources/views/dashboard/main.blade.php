@extends('layouts.dashboard')

@section('title')
    <title> Home </title>
@endsection

@section('main')


    @if ($stars = session('stars'))
        <div class="card card-body">
            @include('tables.stars')
        </div>
    @endif

    @include("dashboard.partials.$mode")

    @if ($stars = session('list'))
        <div class="card card-body m-0">
            @include('tables.stars')
        </div>
    @endif

@endsection
