<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3> Quick Plus </h3>
			</div>
			<div class="card-body">
				<form class="row" action="{{route('quick_plus')}}" method="post">
					@csrf

					<div class="form-group col-md-9">
						<label for="string"> Star, Points, Cloth, Kid </label>
						<input type="text" name="string" class="form-control form-control-lg mb-2" id="string" value="{{old('string')}}" autocomplete="off" autofocus>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline1" name="type" class="custom-control-input" value="regular" checked>
							<label class="custom-control-label" for="customRadioInline1"> regular </label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline2" name="type" class="custom-control-input" value="instagram" @if(old('type') == 'instagram') checked @endif>
							<label class="custom-control-label" for="customRadioInline2"> instagram </label>
						</div>
					</div>

					<div class="col-md-3 align-self-center">
						<button type="submit" class="btn btn-primary btn-block mt-2"> Submit </button>
					</div>

				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h3> Master </h3>
			</div>
			<div class="card-body">
				<form class="row" action="{{route('master')}}" method="post">
					@csrf

					<div class="form-group col-md-6">
						<label for="star"> Star Name </label>
						<input type="text" name="star" class="form-control form-control-lg" id="star" value="{{old('star')}}">
					</div>

					<div class="form-group col-md-3">
						<label for="degree"> Degree </label>
						<input type="number" name="degree" class="form-control form-control-lg" id="degree" value="{{old('degree')}}">
					</div>

					<div class="col-md-3 mx-auto align-self-center">
						<button type="submit" class="btn btn-primary btn-block mt-2"> Submit </button>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3> Quick Add </h3>
			</div>
			<div class="card-body">
				<form class="row" action="{{route('quick_add')}}" method="post">
					@csrf

					<div class="form-group col-md-6">
						<label for="star-add"> Star </label>
						<input type="text" name="star" class="form-control" id="star-add">
					</div>

					<div class="form-group col-md-3">
						<label for="kids"> Kids </label>
						<input type="text" name="kids" class="form-control" id="kids" autocomplete="off">
					</div>

					<div class="form-group col-md-3">
						<label for="cloth"> Cloth </label>
						<input type="text" name="cloth" class="form-control" id="cloth" autocomplete="off">
					</div>

					<div class="form-group col-12">
						<label for="points"> Points </label>
						<input type="text" name="points" class="form-control" id="points" autocomplete="off">
					</div>

					<div class="col-md-3 mx-auto align-self-center">
						<button type="submit" class="btn btn-primary btn-block mt-2"> Submit </button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
