@extends('layouts.app')

@section('scripts')
	@vite('resources/sass/app.scss')
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h2 class="mb-3 px-3">Areas</h2>
			<div class="card">
				<ul class="list-group list-group-flush">
				@foreach (Area::all() as $area)
					<li class="list-group-item py-3">
						{{ $area->label }}
						<a class="stretched-link" href="{{ route('area', $area) }}"></a>
					</li>
				@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
