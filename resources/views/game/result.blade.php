@extends('layouts.dashboard')

@section('title')
    <title> Result </title>
@endsection

@section('main')
    <div class="card card-body p-0">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Star</th>
                    @for ($i=1; $i <= 12; $i++)
                        <th scope="col" class="text-capitalize">
                            <a href="?order={{mn($i)}}" class="text-{{month_color($i)}}"> {{mn($i)}} </a>
                        </th>
                    @endfor
                    <th scope="col"> <a href="?order=sum" class="text-success"> Sum </a> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stars as $i => $star)
                    <tr>
                        <th scope="row" class="text-{{color($i+1)}}">{{$i+1}}</th>
                        <td> <a href="{{url("stars/$star->id")}}"> {{$star->name}} </a> </td>
                        @for ($i=1; $i <= 12; $i++)
                            @php $month = mn($i); @endphp
                            <td> {{nf($star->$month ?? 0)}} </td>
                        @endfor
                        <td> {{nf($star->sum)}} </td>
                    </tr>
                @endforeach
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> {{count($stars)}} </th>
                    @for ($i=1; $i <= 12; $i++)
                        @php $month = mn($i); @endphp
                        <th scope="col" class="text-capitalize text-{{month_color($i)}}"> {{nf($stars->sum($month))}} </th>
                    @endfor
                    <th scope="col" class="text-success"> {{nf($stars->sum('sum'))}} </th>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
