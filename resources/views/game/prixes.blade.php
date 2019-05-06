@extends('layouts.dashboard')

@section('title')
    <title> Prixes </title>
@endsection

@section('main')
    <div class="card card-body">
        <div class="row">
            @foreach ($prixes_list as $month => $prixes)
                <div class="col-md-4 my-2">
                    <div class="card-header text-secondary">
                        {{ucfirst($month)}}
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($prixes as $j => $prix)
                                <li class="list-group-item">
                                    <b> {{$prix->name}} </b>
                                    <span class="badge badge-secondary float-right"> {{nf($prix->$month)}} </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card card-body">
        <table class="table table-bordered table-hover table-stripped">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Star </th>
                    <th> Golds </th>
                    <th> Silvers </th>
                    <th> Bronzes </th>
                    <th> Positions </th>
                    <th> Money </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $row)
                    @if ($row['money'])
                        <tr>
                            <td> {{$row['rank']}} </td>
                            <td> {{$row['star']}} </td>
                            <td @if($row['golds']) class="text-secondary" @endif> {{$row['golds']}} </td>
                            <td @if($row['silvers']) class="text-secondary" @endif> {{$row['silvers']}} </td>
                            <td @if($row['bronzes']) class="text-secondary" @endif> {{$row['bronzes']}} </td>
                            <td @if($row['positions']) class="text-secondary" @endif> {{$row['positions']}} </td>
                            <td class="text-primary"> {{nf($row['money'])}}$ </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
