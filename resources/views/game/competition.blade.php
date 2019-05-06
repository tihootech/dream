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
        @foreach ($competitions as $competition)
            <div class="card">
                <div class="card-header bg-dark text-light">
                    {{$competition->name}}
                </div>
                <div class="card-body">
                    @if ($change)
                        <form class="row justify-content-center" method="post" action="{{url("competition")}}">

                            @csrf
                            <input type="hidden" name="competition_id" value="{{$competition->id}}">
                            <input type="hidden" name="year" value="{{$year}}">

                            @for ($i=1; $i <= 4; $i++)
                                <div class="form-group col-md-3">
                                    <label for="rank{{$i}}"> Rank {{$i}} </label>
                                    <input type="text" name="rank[{{$i}}]" id="rank{{$i}}" class="form-control"
                                        value="{{old('rank')[$i] ?? $competition->get_rank($i,$year)}}">
                                </div>
                            @endfor

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
                        @if (count($result[$competition->id]))
                            <div class="row px-4">
                                @for ($i=1; $i <= 4; $i++)
                                    <div class="col-md-3">
                                        <div class="card card-body bg-{{rank_color($i)}}">
                                            {{$competition->get_rank($i,$year)}}
                                        </div>
                                    </div>
                                @endfor
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
