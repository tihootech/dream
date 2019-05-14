@extends('layouts.dashboard')

@section('title')
    <title> Events </title>
@endsection

@section('main')
    <div class="card card-body">

        <div class="mb-3 text-center">
            @foreach ($types as $type)
                <a href="?type={{$type}}" class="badge @if(request('type') == $type) badge-secondary @else badge-info @endif">
                    {{$type}}
                </a>
            @endforeach
            @if (request('type'))
                <a href="{{url('events')}}" class="badge badge-dark"> none </a>
            @endif
        </div>

        @include('tables.points')

        <div class="center-pagination my-4">
            {{$points->appends($_GET)->links()}}
        </div>
    </div>
@endsection
