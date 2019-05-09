@extends('layouts.dashboard')

@section('title')
    <title> Birthdays </title>
@endsection

@section('main')
    @foreach ($result as $month => $details)
        <div class="card card-body">
            <h3 @if(date('m')==$month) class="text-danger" @endif> {{ucfirst(mn($month))}} ({{count($details)}}) </h3>
            <hr>
            <div class="">
                @foreach ($details as $detail)
                    <span class="badge m-1
                        @if (date('m')==$month)
                            @if(date('d') == $detail->day)
                                badge-danger
                            @elseif(date('d') < $detail->day)
                                badge-success
                            @else
                                badge-info
                            @endif
                        @else
                            badge-dark
                        @endif
                        ">
                        {{$detail->name}}, {{$detail->birthday}}
                    </span>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
