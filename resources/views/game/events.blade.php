@extends('layouts.dashboard')

@section('title')
    <title> Events </title>
@endsection

@section('main')
    <div class="card card-body">

        @include('tables.points')

        <div class="center-pagination my-4">
            {{$points->appends($_GET)->links()}}
        </div>
    </div>
@endsection
