@extends('layouts.app')

@section('scripts')
	@vite('resources/sass/app.scss')
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h2 class="mb-3 px-3">
				{{ $area->label }}
			</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-8">
			<div class="card">
				<div class="card-body">
					<h4 class="border-bottom mb-3 pb-2">Themen ({{ $area->ideas()->count() }})</h4>
					@if ($area->ideas()->count() == 0 )
					<p class="alert alert-info">
						No topics in this area.
					</p>
					@endif
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="card">
				<div class="card-body">
					<h4 class="border-bottom mb-3 pb-2">Info</h4>
					@if ($area->parent_id != null)
					<p>
						Parent:
						<a class="text-decoration-none" href="{{ route('area', $area->parent) }}">
							{{ $area->parent->label }}
						</a>
					</p>
					@endif
					@if ($area->children()->count() > 0 )
					Child-Areas
					<ul>
						@foreach ($area->children()->get() as $item)
						<li>
							<a class="text-decoration-none" href="{{ route('area', $item)}}">
								{{ $item->label }}
							</a>
						</li>
						@endforeach
					</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
