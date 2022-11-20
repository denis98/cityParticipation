<li class="list-group-item list-group-item-action @if (isset($padding))
	py-3
@endif">
	<span class="bg-primary p-2 badge text-white me-3">
		{{ $idea->created_at->format('d.m.Y') }} - {{ $idea->created_at->format('H:i') }}
	</span>
	{{ $idea->title }}
	<a class="stretched-link" href="{{ route('idea.show', $idea)}}"></a>

	<span class="float-end">
		{{ $idea->votes()->upvotes()->count() }}
		<i class="fa fa-thumbs-up ms-2"></i>
	</span>
	<span class="clearfix"></span>
</li>
