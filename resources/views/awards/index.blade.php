@extends('layouts.dashboard')

@section('title')
    <title> Awards </title>
@endsection

@section('main')

    <div class="card">
        <div class="card-header">
            <h3> Assign Trophy </h3>
        </div>
        <div class="card-body">
            <form class="row justify-content-center align-items-end" action="{{url('awards')}}" method="post">
                @csrf

                <div class="form-group col-md-3">
                    <label for="star"> Star Name </label>
                    <input type="text" name="star" id="star" class="form-control form-control-lg" value="{{old('star')}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="trophy"> Select Trophy </label>
                    <select name="trophy" class="selectpicker" id="trophy" data-live-search="true">
                        @foreach ($trophies as $trophy)
                            <option value="{{$trophy->id}}"> {{$trophy->title}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary btn-block mt-3"> Submit </button>
                </div>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3> Awards List </h3>
        </div>
        <div class="card-body">
            @include('tables.awards')
            <div class="center-pagination my-4">
                {{$awards->links()}}
            </div>
        </div>
    </div>

@endsection
