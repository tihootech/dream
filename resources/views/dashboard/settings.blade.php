@extends('layouts.dashboard')

@section('title')
    <title> Settings </title>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            Update Month & Year
        </div>
        <div class="card-body">
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Update Base Points
                </div>
                <div class="card-body">
                    <form class="row" action="{{route('update_base_points')}}" method="post">
                        @csrf
                        @method('PUT')

                        @foreach ($base_points as $i => $base_point)
                            <div class="form-group col-md-6">
                                <label for="type-{{$i}}"> Type </label>
                                <input type="text" name="type[]" class="form-control" id="type-{{$i}}" value="{{$base_point->type}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="quantity-{{$i}}"> Quantity </label>
                                <input type="text" name="quantity[]" class="form-control" id="quantity-{{$i}}" value="{{$base_point->quantity}}">
                            </div>
                            <div class="w-100"></div>
                        @endforeach

                        <div class="col-md-4 align-self-center mx-auto">
                            <button type="submit" class="btn btn-primary btn-block mt-2"> Update Base Points </button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Update Competitions
                </div>
                <div class="card-body">
                    <form class="row" action="{{route('update_competitions')}}" method="post">
                        @csrf
                        @method('PUT')

                        @foreach ($competitions as $i => $competition)

                            <div class="form-group col-md-6">
                                <label for="name-{{$i}}"> Name </label>
                                <input type="text" name="name[]" class="form-control" id="name-{{$i}}" value="{{$competition->name}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="base-{{$i}}"> Base </label>
                                <input type="text" name="base[]" class="form-control" id="base-{{$i}}" value="{{$competition->base}}">
                            </div>

                            <div class="w-100"></div>
                        @endforeach

                        <div class="col-md-4 align-self-center mx-auto">
                            <button type="submit" class="btn btn-primary btn-block mt-2"> Update Competitions </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Update Trophies
                </div>
                <div class="card-body">
                    <form class="row" action="{{route('update_trophies')}}" method="post">
                        @csrf
                        @method('PUT')

                        @foreach ($trophies as $i => $trophy)

                            <div class="form-group col-md-6">
                                <label for="title-{{$i}}"> Title </label>
                                <input type="text" name="title[]" class="form-control" id="title-{{$i}}" value="{{$trophy->title}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="price-{{$i}}"> Price </label>
                                <input type="text" name="price[]" class="form-control" id="price-{{$i}}" value="{{$trophy->price}}">
                            </div>
                            <div class="w-100"></div>
                        @endforeach

                        <div class="col-md-4 align-self-center mx-auto">
                            <button type="submit" class="btn btn-primary btn-block mt-2"> Update Trophies </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
