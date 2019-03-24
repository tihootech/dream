@extends('layouts.dashboard')

@section('title')
    <title> Events </title>
@endsection

@section('main')

    <div class="card card-body">
        @include('tables.awards')
    </div>

@endsection
