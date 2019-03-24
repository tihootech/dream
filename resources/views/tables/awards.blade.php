<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col"> Title </th>
            <th scope="col"> Winner </th>
            <th scope="col"> Money </th>
            <th scope="col"> Month </th>
            <th scope="col"> Year </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($awards as $i => $award)
            <tr>
                <th scope="row">{{$i+1}}</th>
                <td>{{$award->title}}</td>
                <td> <a href="{{url("stars/$award->star_id")}}"> {{$award->star->name}} </a> </td>
                <td>{{nf($award->money)}} $</td>
                <td>{{ucfirst(mn($award->month))}}</td>
                <td>{{$award->year}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
