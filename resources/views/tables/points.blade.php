<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Star</th>
            <th scope="col">Amount</th>
            <th scope="col">Type</th>
            <th scope="col">Month</th>
            <th scope="col">Year</th>
            <th scope="col">Date & Time</th>
            <th scope="col" colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($points as $i => $point)
            <tr>
                <th scope="row">{{$i+1}}</th>
                <td> <a href="{{url("stars/$point->star_id")}}"> {{$point->star->name}} </a> </td>
                <td> {{nf($point->amount)}} </td>
                <td> {{$point->type}} </td>
                <td class="text-capitalize"> {{mn($point->month)}} </td>
                <td> {{$point->year}} </td>
                <td> {{$point->created_at}} </td>
                <td align="center"> <a href="{{url("points/delete/$point->id")}}"> <i class="fa fa-trash text-danger"></i> </a> </td>
                <td align="center"> <a href="{{url("points/$point->id/edit")}}"> <i class="fa fa-edit text-success"></i> </a> </td>
            </tr>
        @endforeach
    </tbody>
</table>
