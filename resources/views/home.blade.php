@extends('layouts.app')

@section('scripts')
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endsection

@php
	$popularIdeas = Idea::upvotes()->limit(5)->get();
@endphp

@section('content')
<div class="container">
		<div class="row">
			<div class="col-8">
				<div id="map" class="map"></div>
				<div id="info"></div>
			</div>
			<div class="col-4">
				<h3 class="mb-3 ps-3">Popular Ideas</h3>
				<ul class="list-group mt-0">
				@foreach ($popularIdeas as $idea)
					<li class="idea list-group-item list-group-item-action" data-idea-id="{{ $idea->id }}">
							<h6 class="p-none">
								{{ $idea->quarter }}
							</h6>
							<h4>
								{{ $idea->title }}
							</h4>
							<p class="fs">
								{{ $idea->topic }}
							</p>
							<div class="position-absolute fs-4" style="bottom: 15px; right: 25px;">
								{{ $idea->votes_count }} <i class="fas fa-thumbs-up ms-2 "></i>
						</div>
					</li>
				@endforeach
				</ul>
			</div>
		</div>
</div>
<script type="text/javascript">
	var ideaMarkers = [];

	@foreach ($popularIdeas as $idea)
	ideaMarkers.push({
		id: {{ $idea->id }},
		address: "{{ $idea->location }}",
		coordinates: {{ $idea->coordinates}},
	});
	@endforeach
</script>
@endsection
