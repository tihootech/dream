@extends('layouts.dashboard')

@section('title')
    <title> Details </title>
@endsection

@section('main')

    <div class="text-center">
        <a href="{{url("stars")}}" class="btn btn-secondary"> Stars </a>
        <a href="{{url("details")}}" class="btn btn-secondary"> Details </a>
        <a href="{{url("details?mode=youngest")}}" class="btn btn-secondary"> Youngest </a>
        <a href="{{url("details?mode=tallest")}}" class="btn btn-secondary"> Tallest </a>
    </div>
    <div class="card card-body mt-3">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Name </th>
                    <th scope="col"> Country </th>
                    <th scope="col"> State </th>
                    <th scope="col"> City </th>
                    <th scope="col"> Birthday </th>
                    <th scope="col"> Age </th>
                    <th scope="col"> Height </th>
                    <th scope="col" colspan="2"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $i => $detail)
                    <tr>
                        <th scope="row">{{$i+1}}</th>
                        <td> <a href="{{url("stars/".$detail->star_id())}}"> {{$detail->name}} </a> </td>
                        <td> {{$detail->country ?? '-'}} </td>
                        <td> {{$detail->state ?? '-'}} </td>
                        <td> {{$detail->city ?? '-'}} </td>
                        <td> {{$detail->birthday ?? '-'}} </td>
                        <td> {{$detail->age()}} </td>
                        <td> {{$detail->height ?? '-'}} </td>
                        <td align="center">
                            @if ($detail->star_id())
                                <a href="{{url("stars/".$detail->star_id()."/edit")}}"> <i class="fa fa-edit text-success"></i> </a>
                            @else
                                <em> - </em>
                            @endif
                        </td>
                        <td align="center">
                            <form class="d-inline" action="{{url("details/$detail->name")}}" method="post" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-link p-0">
                                    <i class="fa fa-trash text-danger"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
