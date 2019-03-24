@extends('layouts.dashboard')

@section('title')
    <title> Home </title>
@endsection

@section('main')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3> Quick Plus </h3>
                </div>
                <div class="card-body">
                    <form class="row" action="{{route('quick_plus')}}" method="post">
                        @csrf

                        <div class="form-group col-md-9">
                            <label for="string"> Star, Regular, Cloth, Kid </label>
                            <input type="text" name="string" class="form-control form-control-lg" id="string" value="{{old('string')}}" autocomplete="off">
                        </div>

                        <div class="col-md-3 mx-auto align-self-center">
                            <button type="submit" class="btn btn-primary btn-block mt-2"> Submit </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3> Quick Add </h3>
                </div>
                <div class="card-body">
                    <form class="row" action="{{route('quick_add')}}" method="post">
                        @csrf

                        <div class="form-group col-md-8">
                            <label for="star"> Star </label>
                            <input type="text" name="star" class="form-control" id="star">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="kids"> Kids </label>
                            <input type="text" name="kids" class="form-control" id="kids" autocomplete="off">
                        </div>

                        <div class="form-group col-12">
                            <label for="points"> Points </label>
                            <input type="text" name="points" class="form-control" id="points" autocomplete="off">
                        </div>

                        <div class="col-md-3 mx-auto align-self-center">
                            <button type="submit" class="btn btn-primary btn-block mt-2"> Submit </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
