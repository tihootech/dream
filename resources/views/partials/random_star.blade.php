<div class="random-star-box">
	<div id="stars-list">
		{{-- will be filled by ajax --}}
	</div>
	<a href="javascript:void" class="color-inherit generate-random-star"><i class="fa fa-random"></i></a>
	@if (top20_mode())
		<a href="javascript:void" class="color-inherit generate-random-star ml-2" data-tops="20"><i class="fa fa-arrow-up"></i></a>
	@endif
</div>
