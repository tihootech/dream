@extends('layouts.dashboard')

@section('title')
    <title> Possible Stars </title>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <h3> There are some possible stars. </h3>
            <p> Please choose which one of following stars you mean ? </p>
        </div>
        <div class="card-body">
            <form class="row" action="{{route('quick_plus')}}" method="post">
                @csrf
                <input type="hidden" name="string" value="{{$string}}">
                <input type="hidden" name="type" value="{{$type}}">

                @foreach ($possible_stars as $star)
                    <button type="submit" name="name" value="{{$star->name}}" class="btn btn-warning m-1">
                        {{$star->name}}
                    </button>
                @endforeach

            </form>
        </div>
    </div>
@endsection
