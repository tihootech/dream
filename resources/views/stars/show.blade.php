@extends('layouts.dashboard')

@section('title')
    <title> {{$star->name}} </title>
@endsection

@section('main')
    <div class="card card-body">
        @php
            dd($star->details);
        @endphp
    </div>
@endsection
