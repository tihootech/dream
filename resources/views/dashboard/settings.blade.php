@extends('layouts.dashboard')

@section('title')
    <title> Settings </title>
@endsection

@section('main')
    <div class="card card-body">
        <form class="row" action="{{route('update_time')}}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group col-md-3 ml-auto">
                <label for="cm"> Current Month </label>
                <input type="text" name="cm" class="form-control" id="cm" value="{{cm()}}">
            </div>

            <div class="form-group col-md-3">
                <label for="cy"> Current Year </label>
                <input type="text" name="cy" class="form-control" id="cy" value="{{cy()}}">
            </div>

            <div class="col-md-2 align-self-center mr-auto">
                <button type="submit" class="btn btn-primary btn-block mt-2"> Update Month & Year </button>
            </div>

        </form>
    </div>
    <div class="card card-body">
        <form class="row" action="{{route('update_base_points')}}" method="post">
            @csrf
            @method('PUT')

            @foreach ($base_points as $i => $base_point)
                <div class="form-group col-md-3 ml-auto">
                    <label for="type-{{$i}}"> Type </label>
                    <input type="text" name="type[]" class="form-control" id="type-{{$i}}" value="{{$base_point->type}}">
                </div>

                <div class="form-group col-md-3 mr-auto">
                    <label for="quantity-{{$i}}"> Quantity </label>
                    <input type="text" name="quantity[]" class="form-control" id="quantity-{{$i}}" value="{{$base_point->quantity}}">
                </div>
                <div class="w-100"></div>
            @endforeach

            <div class="col-md-2 align-self-center mx-auto">
                <button type="submit" class="btn btn-primary btn-block mt-2"> Update Base Points </button>
            </div>

        </form>
    </div>
@endsection
