@extends('layouts.app')

@section('scripts')
	@vite('resources/sass/app.scss')
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h2 class="mb-3 px-3">
				All Ideas

				<span class="float-end fs-4">
					<form method="GET">
						<div class="btn-group" role="group" aria-label="Basic outlined example">
							<button type="submit" name="sorting" value="time" class="btn btn-outline-primary @if ($sort == "time")
								active
							@endif">Time</button>
							<button type="submit" name="sorting" value="upvotes" class="btn btn-outline-primary @if ($sort == "upvotes")
								active
							@endif">Upvotes</button>
						</div>
					</span>
				</h2>
			<div class="card">
					<ul class="list-group list-group-flush">
						@php
							$padding = true;
						@endphp
					@foreach ($ideas->get() as $idea)
						@include('components.idea_entry')
					@endforeach
					</ul>
			</div>
		</div>
	</div>
</div>
@endsection
