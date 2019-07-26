<label for="{{$name}}}"> {{display_snake($name)}} </label>
<div class="extras">
	<b class="mx-1 text-primary" title="Count" data-toggle="tooltip"> {{$count ?? 'n'}} </b>
	<span class="mx-1 text-danger" title="Ratio For Each One" data-toggle="tooltip"> {{$count ? $ratio/$count : $ratio.'/n'}} </span>
	<a href="javascript:void" class="top20-random-generator text-secondary mx-1">
		<i class="fa fa-random"></i>
	</a>
</div>
<input type="text" id="{{$name}}}" name="{{$name}}[stars]" class="form-control target" autocomplete="off"
	@isset($final_value)
		value="{{$semi_final->$name ?? old($name)['stars']}}"
	@else
		value="{{$semi_final->extract($name, $day) ?? old($name)['stars']}}"
	@endisset
>
<input type="hidden" name="{{$name}}[ratio]" value="{{$ratio}}" class="form-control">
