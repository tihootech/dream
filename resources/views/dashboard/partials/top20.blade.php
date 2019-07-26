<div class="text-center">
	<a href="{{url("result?order=sum&limit=20")}}" class="btn btn-secondary" target="_blank">Result</a>
</div>
<div class="card card-body mt-3">
	<form method="post" action="{{url('final/initialize')}}">
		<h2 class="mb-3 text-primary semi-final-title"> Initialize <small class="fa fa-undo pointer text-secondary ml-1"></small> </h2>
		<div class="show-details @if(!$semi_final) hidden @endif">
			Base is : {{nf($semi_final->base ?? 0)}}
		</div>
		<div class="change-details @if($semi_final) hidden @endif">
			<div class="row justify-content-center">
				@csrf
				<div class="col-md-2 form-group day-group">
					<label for="base"> Base </label>
					<input type="text" name="base" value="{{$semi_final->base ?? null}}" class="form-control">
				</div>
				<div class="col-md-1">
					<button type="submit" class="btn btn-block btn-primary mt-3">Save</button>
				</div>

			</div>
		</div>
	</form>
	<hr>
	@if($semi_final)
		<form method="post" action="{{url('final/start')}}">
			<h2 class="mb-3 text-primary semi-final-title"> Start <small class="fa fa-undo pointer text-secondary ml-1"></small> </h2>
			<div class="show-details @if(!$semi_final->performers || !$semi_final->performers) hidden @endif">
				<p>
					Performers : <span class="badge badge-info"> {{$semi_final->performers}} </span>
				</p>
				<p>
					Announcer : <span class="badge badge-info"> {{$semi_final->announcer}} </span>
				</p>
			</div>
			<div class="change-details @if($semi_final->performers && $semi_final->performers) hidden @endif">
				<div class="row justify-content-center">
					@csrf
					<div class="col-md-5 form-group day-group">
						@include('partials.day_group', ['ratio'=>40, 'name'=>'performers', 'count'=>4, 'final_value'=>-1])
					</div>
					<div class="col-md-2 form-group day-group">
						@include('partials.day_group', ['ratio'=>20, 'name'=>'announcer', 'count'=>1, 'final_value'=>-1])
					</div>
					<div class="col-md-1">
						<button type="submit" class="btn btn-block btn-primary mt-3">Save</button>
					</div>
				</div>
			</div>
		</form>
		<hr>
		@for ($day=1; $day <= $current_day; $day++)
			<form method="post" action="{{url('final/days')}}">
				@csrf
				<input type="hidden" name="day" value="{{$day}}">

				<h2 class="mb-3 text-primary semi-final-title"> Day {{$day}} <small class="fa fa-undo pointer text-secondary ml-1"></small> </h2>
				@if($day <= $current_day)
					<div class="show-details @if($day == $current_day) hidden @endif">
						<div class="row">
							<div class="col-md-4">
								Morning Sex : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('morning_sex', $day)}} </span>
							</div>
							<div class="col-md-4">
								Secretary : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('secretary', $day)}} </span>
							</div>
							<div class="col-md-4">
								Best Kid : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('best_kid', $day)}} </span>
							</div>
							<div class="col-md-4">
								Show : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('show', $day)}} </span>
							</div>
							<div class="col-md-4">
								Threesome : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('threesome', $day)}} </span>
							</div>
							<div class="col-md-4">
								Nightovers : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('nightovers', $day)}} </span>
							</div>
							<div class="col-md-4">
								Winner 1 : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('winner_1', $day)}} </span>
							</div>
							<div class="col-md-4">
								Winner 2 : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('winner_2', $day)}} </span>
							</div>
							<div class="col-md-4">
								Winner 3 : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('winner_3', $day)}} </span>
							</div>
							<div class="col-md-4">
								Winner 4 : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('winner_4', $day)}} </span>
							</div>
							<div class="col-md-4">
								Winner Overall : <span class="badge badge-info d-block mb-2"> {{$semi_final->extract('winner_overall', $day)}} </span>
							</div>
						</div>
					</div>
				@endif
				<div class="change-details @if($day != $current_day) hidden @endif">
					<div class="row justify-content-center">
						<div class="col-md-4 form-group day-group">
							@include('partials.day_group', ['ratio'=>6, 'name'=>'morning_sex', 'count'=>null])
						</div>
						<div class="col-md-2 form-group day-group">
							@include('partials.day_group', ['ratio'=>2, 'name'=>'secretary', 'count'=>1])
						</div>
						<div class="col-md-2 form-group day-group">
							@include('partials.day_group', ['ratio'=>5, 'name'=>'best_kid', 'count'=>1])
						</div>
						<div class="col-md-2 form-group day-group">
							@include('partials.day_group', ['ratio'=>5, 'name'=>'show', 'count'=>1])
						</div>
						<div class="col-md-3 form-group day-group">
							@include('partials.day_group', ['ratio'=>8, 'name'=>'threesome', 'count'=>2])
						</div>
						@if($day%5 == 0)
							<div class="col-md-2 form-group day-group">
								@include('partials.day_group', ['ratio'=>12, 'name'=>'pool_party', 'count'=>1])
							</div>
						@endif
						<div class="col-md-4 form-group day-group">
							@include('partials.day_group', ['ratio'=>10, 'name'=>'nightovers', 'count'=>null])
						</div>
					</div>
					<div class="row mt-3">
						@foreach ($groups as $number => $group)
							<div class="col-md-3">
								<div class="card">
									<div class="card-header">
										Group {{$number}}
									</div>
									<div class="card-body">
										@if ($day == $current_day)
											<ul>
												@foreach ($group as $member)
													<li> {{$member}} </li>
												@endforeach
											</ul>
											<hr>
										@endif
										@include('partials.day_group', ['ratio'=>5, 'name'=>'winner_'.$number, 'count'=>1])
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="col-md-3 mx-auto">
						@include('partials.day_group', ['ratio'=>10, 'name'=>'winner_overall', 'count'=>1])
					</div>
					<div class="w-100"></div>
					<div class="col-md-1 mt-3 mx-auto">
						<button type="submit" class="btn btn-primary btn-block"> Save </button>
					</div>
					@if ($day == $current_day)
						<div class="alert alert-warning mt-3">
							<h3>Stars Not Mentioned In Groups : </h3>
							<hr>
							@foreach ($top20_stars as $star)
								@if(!in_array($star->name, $all_members))
									<span class="mr-2"> {{$star->name}} </span>
								@endif
							@endforeach
						</div>
						<div class="alert alert-warning">
							<h3>Stars With Multiple Chances : </h3>
							<hr>
							@foreach ($top20_stars as $star)
								@if(in_array($star->name, $duplicate_members))
									<span class="mr-2"> {{$star->name}} </span>
								@endif
							@endforeach
						</div>
					@endif
				</div>
				<hr>
			</form>
		@endfor
		<h2 class="mb-3 text-primary semi-final-title"> Finalize </h2>
		<div class="row justify-content-center">
			<div class="col-md-2 form-group day-group">
				@include('partials.day_group', ['ratio'=>20, 'name'=>'queen', 'count'=>1, 'final_value'=>-1])
			</div>
			<div class="col-md-2 form-group day-group">
				@include('partials.day_group', ['ratio'=>15, 'name'=>'manager', 'count'=>1, 'final_value'=>-1])
			</div>
			<div class="col-md-3 form-group day-group">
				@include('partials.day_group', ['ratio'=>16, 'name'=>'sitter', 'count'=>2, 'final_value'=>-1])
			</div>
			<div class="col-md-4 form-group day-group">
				@include('partials.day_group', ['ratio'=>15, 'name'=>'sucker', 'count'=>3, 'final_value'=>-1])
			</div>
			<div class="col-md-6 form-group day-group">
				@include('partials.day_group', ['ratio'=>12, 'name'=>'layers', 'count'=>4, 'final_value'=>-1])
			</div>
		</div>
	@endif

</div>
