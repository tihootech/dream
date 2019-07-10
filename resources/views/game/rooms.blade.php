@extends('layouts.dashboard')

@section('title')
    <title> Rooms </title>
@endsection

@section('main')
    <div class="card card-body">
        <div class="row">
            @foreach ($rooms as $i => $room)
                @if ($room->status != 1)
                    <div class="col-md-4">
                        <div class="card room-card">
                            <div class="card-header text-primary">
                                Block {{$room->block}}, Room {{$room->number}}
                                <a href="javascript:void" class="float-right text-secondary trigger-change-room" data-row-number="{{$i}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($room->stars as $star)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-7">
                                                    {{$star->name}}
                                                </div>
                                                <div class="col-5 change-room-{{$i}} hidden">
                                                    <form class="row" action="{{url("rooms/$star->id")}}" method="post">
                                                        @csrf
                                                        <div class="col-5 px-1">
                                                            <input type="text" name="block" value="{{$star->room->block}}" class="form-control">
                                                        </div>
                                                        <div class="col-5 px-1">
                                                            <input type="text" name="number" value="{{$star->room->number}}" class="form-control">
                                                        </div>
                                                        <div class="col-2 px-1">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
