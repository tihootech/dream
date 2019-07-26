@extends('layouts.dashboard')

@section('title')
    <title> Competition </title>
@endsection

@section('main')
    <div class="card card-body">
        <div class="text-center mb-3">
            <a href="{{url('competition?change=1')}}" class="btn mx-1 btn-outline-primary"> <i class="fa fa-edit mr-1"></i> Change </a>
            <a href="{{url('competition')}}" class="btn mx-1 btn-outline-primary"> <i class="fa fa-eye mr-1"></i> Watch </a>
        </div>
        <div class="alert alert-info">
            <ul>
                <li> Competitions are created in <a target="_blank" href="{{url('setting')}}"> Setting </a> </li>
                <li> Each competition has many Winners </li>
                <li> Base is 10,000$ for money, and 2500 for points </li>
                <li> formula is BASE * (12/RANK) * BASE </li>
                <li> If you check "assign points too", it will assign points for new star but i will not delete points assigned to pthe previous star. You have to delete it manually. </li>
            </ul>
        </div>
        @foreach ($competitions as $competition)
            <div class="card">
                <div class="card-header bg-dark text-light">
                    {{$competition->name}} (base:{{$competition->base}})
                </div>
                <div class="card-body">
                    @if ($change)
                        <form class="row justify-content-center" method="post" action="{{url("competition")}}">

                            @csrf
                            <input type="hidden" name="competition_id" value="{{$competition->id}}">
                            <input type="hidden" name="year" value="{{$year}}">

                            @foreach ($competition->winners_in($year, true) as $i => $winner)
                                <div class="form-group col-md-3">
                                    <label for="rank-{{$i}}"> Rank {{$i+1}} </label>
                                    <input type="text" name="rank[{{$i+1}}]" id="rank-{{$i}}" class="form-control"
                                        value="{{old('rank')[$i+1] ?? $winner->star->name ?? null}}">
                                </div>
                            @endforeach

                            <div class="col-12 text-center my-4">
                                <input class="form-check-input" type="checkbox" name="points" value="1">
                                Add Points Too
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-check mr-1"></i> Confirm
                                </button>
                            </div>

                        </form>
                    @else
                        @if ( count($competition->winners_in($year)) )
                            <div class="row px-4">
                                @foreach ($competition->winners_in($year) as $i => $winner)
                                    <div class="col-md-3">
                                        <div class="card card-body bg-{{rank_color($i+1)}}">
                                            <ul class="list-group">
                                                <li class="list-group-item no-bg">
                                                    <a href="{{url("stars/$winner->star_id")}}" class="color-inherit"> {{$winner->star->name ?? null}} </a>
                                                </li>
                                                <li class="list-group-item no-bg">
                                                    <a href="{{url("stars/$winner->star_id")}}" class="color-inherit"> {{nf($winner->money)}}$ </a>
                                                </li>
                                                <li class="list-group-item no-bg">
                                                    <a href="{{url("stars/$winner->star_id")}}" class="color-inherit"> {{nf($winner->points)}} pts </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                not happpend in this year...
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
