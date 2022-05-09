@extends('layouts.main')

@section('title')
    FAQ
@endsection

@section('title-desc')
	Frequently Ask Questions (Pertanyaan Umum)
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div id="accordion" class="accordion-wrapper mb-3">
				@foreach ($data as $item)
					<div class="card">
						<div id="heading_{{ $item->id }}" class="card-header">
							<button type="button" data-toggle="collapse" data-target="#collapse_{{ $item->id }}" aria-expanded="false" aria-controls="collapses_{{ $item->id }}" class="text-left m-0 p-0 btn btn-link btn-block"><h6 class="m-0 p-0">{{ $item->pertanyaan }}</h6></button>
						</div>
						<div data-parent="#accordion" id="collapse_{{ $item->id }}" class="collapse">
							<div class="card-body">{!! $item->jawaban !!}</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection