@extends('layouts.dashboard')

@section('title')
    <title> Top10 Track </title>
@endsection

@section('main')
    <div class="row">
		@foreach ($tops as $month => $top10)
			<div class="col-md-3 my-2">
				<h2 class="text-capitalize mb-2 text-secondary"> {{mn($month)}} </h2>
				<ul class="list-group">
					@foreach ($top10 as $star)
						<li class="list-group-item"> {{$star->name}} : {{nf($star->sum)}} </li>
					@endforeach
				</ul>
			</div>
		@endforeach
    </div>
@endsection
