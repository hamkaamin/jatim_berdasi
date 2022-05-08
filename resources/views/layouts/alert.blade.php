<div class="col-12" id="container-alert">
	@if (session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Success!</strong> {!! session('success') !!}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@elseif(session('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Error!</strong> {!! session('error') !!}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@elseif($errors->any())
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<ul class="mb-0">
				@foreach ($errors->all() as $item)
					<li>{{ $item }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
</div>