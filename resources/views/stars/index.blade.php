@extends('layouts.dashboard')

@section('title')
    <title> Events </title>
@endsection

@section('main')

    <div class="card card-body">

        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Name </th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stars as $i => $star)
                    <tr>
                        <th scope="row">{{$i+1}}</th>
                        <td> <a href="{{url("stars/$star->id")}}"> {{$star->name}} </a> </td>
                        <td align="center"> <a href="{{url("stars/$star->id/edit")}}"> <i class="fa fa-edit text-success"></i> </a> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
