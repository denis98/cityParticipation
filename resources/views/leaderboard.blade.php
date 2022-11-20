@extends('layouts.app')

@section('scripts')
	@vite('resources/sass/app.scss')
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h2 class="px-3 mb-3">Community/Leaderboard</h2>
			<div class="card">
				<div class="card-body">

					<div class="row">
						<div class="col">
							<h4 class="mb-3 ps-3">Submitted ideas</h4>
							<ul class="list-group">
							@foreach (User::byIdeas()->get() as $user)
								@if ($user->ideas_count == 0)
									@break;
								@endif
								<li class="list-group-item">
									{{ $user->name }} ({{ $user->ideas_count }})
									<a href="{{ route('profile', $user) }}" class="stretched-link"></a>
								</li>
							@endforeach
							</ul>
						</div>
						<div class="col">
							<h4 class="mb-3 ps-3">Most upvotes</h4>
							<ul class="list-group">
							@foreach (
								DB::table('votes')
									->join('ideas', 'ideas.id', '=', 'votes.idea_id')
									->join('users', 'users.id', '=', 'issuer_id')
									->select('issuer_id as id', 'users.name as name', DB::raw('count(*) as upvotes'))
									->where('voting', '=', Vote::UPVOTE)
									->groupBy('ideas.issuer_id')
									->orderBy('upvotes', 'DESC')
									->get() as $user)
								<li class="list-group-item">
									{{ $user->name }} ({{ $user->upvotes }})
									<a href="{{ route('profile', $user->id) }}" class="stretched-link"></a>
								</li>
							@endforeach
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
