@extends('layouts.dashboard')

@section('title')
    <title> {{$star->name}} </title>
@endsection

@section('main')
    <div class="card card-body">
        <div class="row justify-conent-center">
            <div class="col-md-4">
                <div class="card">
                    <img class="img-fluid" src="../assets/images/card-img.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title"> {{$star->name}} </h3>
                        <p class="card-text">
                            This Month Rank : <span class="badge badge-info mr-4"> {{$star->rank('month')}} </span>
                            This Year Rank : <span class="badge badge-info"> {{$star->rank('year')}} </span>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> Country : {{$star->details->country ?? '-'}} </li>
                        <li class="list-group-item"> State : {{$star->details->state ?? '-'}} </li>
                        <li class="list-group-item"> City : {{$star->details->city ?? '-'}} </li>
                        <li class="list-group-item" title="{{$star->details->birthday ?? '-'}}" data-toggle="tooltip">
                            Age : {{$star->age()}} years old.
                        </li>
                        <li class="list-group-item"> Height : {{$star->details->height ?? '-'}}cm </li>
                    </ul>
                    <div class="card-body">
                        <a href="{{url("stars/$star->id/edit")}}" class="card-link text-success"> <i class="fa fa-edit mr-1"></i> Edit </a>
                        <form class="d-inline" action="{{url("stars/$star->id")}}" method="post" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-link text-danger">
                                <i class="fa fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @include('tables.points', ['points' => $star->recent_points])
                <hr>
                <div class="text-center">
                    <a href="{{url("events?sid=$star->id")}}"> See All </a>
                </div>
            </div>
        </div>
    </div>
@endsection
