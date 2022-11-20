@extends('layouts.app')

@section('scripts')
	@vite('resources/sass/app.scss')
@endsection

@section('content')
<div class="container">
	<div class="row mb-3">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h2 class="border-bottom mb-3 pb-2">Profile of {{ $user->name }}</h2>
					<table class="table table-striped">
						<tr>
							<td>
								Active since
							</td>
							<td>
								{{ $user->created_at->format('d.m.Y')}}
							</td>
						</tr>
						<tr>
							<td>
								Created ideas
							</td>
							<td> {{ $user->ideas()->count() }}</td>
						</tr>
						<tr>
							<td>
								Received upvotes
							</td>
							<td>
								{{ $user->votes()->upvotes()->count() }}
							</td>
						</tr>
						<tr>
							<td>
								Votes given
							</td>
							<td>
								{{ $user->voted()->count() }}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h4 class="mb-3">Ideas ({{ $user->ideas()->count() }})</h4>
					@if ($user->ideas()->count() > 0)

						<ul class="list-group list-group-flush">
						@foreach ($user->ideas as $idea)
							@include('components.idea_entry')
						@endforeach
						</ul>
						@else
						<p class="alert alert-info">
							This user hasn't shared any ideas yet.
						</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
