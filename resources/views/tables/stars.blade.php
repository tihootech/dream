<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col"> Name </th>
            <th scope="col"> Country </th>
            <th scope="col"> State </th>
            <th scope="col"> City </th>
            <th scope="col"> Age </th>
            <th scope="col"> Height </th>
            <th scope="col" colspan="3"> Actions </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stars as $i => $star)
            <tr>
                <th scope="row">{{$i+1}}</th>
                <td> <a href="{{url("stars/$star->id")}}"> {{$star->name}} </a> </td>
                <td> {{$star->details->country ?? '-'}} </td>
                <td> {{$star->details->state ?? '-'}} </td>
                <td> {{$star->details->city ?? '-'}} </td>
                <td> {{$star->age()}} </td>
                <td> {{$star->details->height ?? '-'}} </td>
                <td align="center">
                    <a href="https://google.com/search?q={{str_replace(' ','+',$star->name)}}+bio" target="_blank">
                        <i class="fa fa-globe text-primary"></i>
                    </a>
                </td>
                <td align="center">
                    <a href="{{url("stars/$star->id/edit")}}"> <i class="fa fa-edit text-success"></i> </a>
                </td>
                <td align="center">
                    <form class="d-inline" action="{{url("stars/$star->id")}}" method="post" onsubmit="return confirm('Are you sure?');">
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
