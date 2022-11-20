@extends('layouts.app')

@section('scripts')
	@vite(['resources/sass/app.scss', 'resources/js/idea.js'])
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h2 class="px-3 mb-3">
				Idea-Details "{{ $idea->title }}"
				<span class="float-end">
					<button class="btn btn-md btn-secondary" data-bs-toggle="modal" data-bs-target="#post-report-modal">
						<i class="fas fa-flag me-2"></i>
						Report
					</button>
					@if (Auth::id() == $idea->issuer_id)
						<button class="btn btn-md btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal">
							<i class="fas fa-trash-alt me-2"></i>
							Delete
						</button>
					@endif
				</span>
			</h2>
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-8">
							<div class="card mb-3">
								<div class="card-body">
									<h4 class="border-bottom mb-3 pb-2">Description</h4>
									<p>
										{{ $idea->description }}
									</p>
									<hr>
									<h5>Info</h5>
									<p class="mb-0">
										Topic: {{ $idea->topic }}
									</p>
									<p class="mb-0">
										Issued at: {{ $idea->created_at->format('d.m.Y') }}
									</p>
									<p class="mb-0">
										Location: {{ $idea->quarter }}, {{ $idea->street }}
									</p>
								</div>
							</div>

							<div class="card mb-3">
								<div class="card-body">
									<h4 class="border-bottom mb-3 pb-2">
										Attachments ({{ $idea->attachments()->count() }})
										<span class="float-end">
											<button class="btn btn-sm btn-primary" style="margin-top:-5px;" type="button" data-bs-toggle="modal" data-bs-target="#upload-attachments-modal">
												Upload
											</button>
										</span>
										<div class="clearfix"></div>
									</h4>
									@if ($idea->attachments()->count() == 0)
										<p class="alert alert-info mb-0">
											This idea has no attachments yet.
										</p>
										@else
										<ul class="list-group">
										@foreach ($idea->attachments as $file)
											<li class="attachment list-group-item list-group-item-active" @if ($file->icon == "fa fa-image")
												data-image="1" data-image-source="{{ route('image.preview', $file) }}" data-bs-toggle="modal" data-bs-target="#image-preview-modal"
											@endif data-file-id="{{ $file->id }}">
												<i class="{{ $file->icon }} me-3"></i>
												{{ $file->displayName }}
											</li>
										@endforeach
										</ul>
									@endif
								</div>
							</div>

							<div class="card mb-3">
								<div class="card-body">
									<h4 class="border-bottom mb-3 pb-2">
										Discussion <i class="far fa-comments ms-3"></i>
										<span class="float-end">
											<button data-bs-toggle="modal" data-bs-target="#post-comment-modal" type="button" class="btn btn-sm btn-primary">
												New comment
											</button>
										</span>
										<div class="clearfix"></div>
									</h4>
									@if ($idea->comments()->count() == 0)
										<p class="alert alert-info mb-0">
											This idea is not discussed yet.
										</p>
										@else
										<ul class="list-group list-group-flush">
										@foreach ($idea->comments as $comment)
											<li class="list-group-item">
												{{ $comment->content }}
												<br>
												<small class="text-primary">{{ $comment->issuer->name}} at {{ $comment->created_at->format('d.m.Y - H:i') }}</small>

												@if ($comment->issuer == Auth::user())
												<span class="position-absolute btn btn-md btn-outline-danger" style="right: 0px; top: 10px;">
													<i class="fa fa-trash"></i>
												</span>
												@endif
											</li>
										@endforeach
										</ul>
									@endif
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="mini-map mb-3" id="map"></div>
							<div class="card mb-3">
								<div class="card-body">
									<h4 class="mb-3">Votings ({{ $idea->votes()->count() }})</h4>
									<div class="row">
										<div class="vote-col col mb-3 text-center @if (Auth::user()->hasUpvoted($idea))
											text-primary
										@endif">
											<i class="fa-3x far fa-thumbs-up vote" data-vote="up"></i>
											<b class="fs-2 ps-3">
												{{ $idea->votes()->upvotes()->count() }}
											</b>
										</div>
										<div class="vote-col col mb-3 text-center @if (Auth::user()->hasDownvoted($idea))
											text-primary
										@endif">
											<b class="fs-2 pe-3">
												{{ $idea->votes()->downvotes()->count() }}
											</b>
											<i class="fa-3x far fa-thumbs-down vote" data-vote="down"></i>
										</div>
									</div>
									<div class="row">
										<div class="col text-center" id="already-voted">

										</div>
									</div>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-body">
									<h4 class="mb-3">Issued by</h4>
									<h6>
										{{ $idea->issuer->name }} ({{ $idea->issuer->ideas()->count() }})
										<a href="{{ route('profile', $idea->issuer) }}" class="stretched-link"></a>
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="image-preview-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					Preview of <span class="text-primary" id="preview-filename"></span>
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<img id="image-preview" class="w-100" src="" alt="">
			</div>
			@if (Auth::user() == $idea->issuer)
				<div class="p-3">
					{!! Form::open([
						'method' => 'PATCH',
						'route' => ['attachment.update', $idea]
						]) !!}

						<div class="row">
							<div class="col">
								{!! Form::text('displayName', null, [
									'class' => 'form-control',
									'id' => 'displayName',
									'placeholder' => 'Change showed name'
									])!!}
							</div>

							<div class="col-2">
								{!! Form::submit('Save',  [
									'class' => 'btn btn-md btn-outline-primary'
									])!!}
							</div>
						</div>

					{!! Form::close() !!}
				</div>
			@endif
		</div>
	</div>
</div>
<div class="modal" id="upload-attachments-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					Upload Attachments
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				{!! Form::open([
					'method' => 'post',
					'files' => true,
					'route' => ['idea.attachments', $idea]
					]) !!}

				<fieldset class="mb-3">
				{!! Form::file('attachments[]', [
						'class' => 'form-control',
						'multiple' => true,
						]) !!}
				</fieldset>

				{!! Form::submit('Upload', [
					'class' => 'btn btn-md btn-primary'
					])!!}

				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="post-comment-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					New Comment
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				{!! Form::open([
					'method' => 'post',
					'files' => true,
					'route' => ['idea.comments.store', $idea]
					]) !!}

				<fieldset class="mb-3 form-floating">
				{!! Form::text('content', null, [
					'class' => 'form-control',
					'placeholder' => '',
					])!!}
					{!! Form::label('What you want to say?') !!}
				</fieldset>

				{!! Form::submit('Save', [
					'class' => 'btn btn-md btn-primary'
					])!!}

				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="post-report-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					Report this idea
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				{!! Form::open([
					'method' => 'post',
					'files' => true,
					'route' => ['idea.report', $idea]
					]) !!}

				<fieldset class="mb-3 form-floating">
				{!! Form::textarea('content', null, [
					'class' => 'form-control',
					'placeholder' => ''
					])!!}
					{!! Form::label('content', 'Why do you want to report this idea?')!!}
				</fieldset>

				{!! Form::submit('Save', [
					'class' => 'btn btn-md btn-primary'
					])!!}

				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="delete-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					New Comment
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				{!! Form::open([
					'method' => 'delete',
					'files' => true,
					'route' => ['idea.delete', $idea]
					]) !!}

				<p>
					Are you sure that you want to delete this idea?
				</p>

				{!! Form::submit('Delete', [
					'class' => 'btn btn-md btn-danger'
					])!!}

				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let idea = {
		coordinates: {{ $idea->coordinates }},
	};

	document.addEventListener('DOMContentLoaded', function() {
		$ = window.$;

		@if ($idea->issuer != Auth::user())
		var voted = {{ Auth::user()->hasUpvoted($idea) ? 1 : (Auth::user()->hasDownvoted($idea) ? 1 : -1 ) }};

		$(".vote").on("click", function() {
			var vote = $(this).attr("data-vote");

			$.ajax({
				url: '/idea/{{ $idea->id }}/vote',
				method: 'PATCH',
				data: {
					voting: vote
				},
				success: function(res) {
					document.location.reload();
				}
			});
		});
		@endif

		$(".attachment").on("click", function() {
			if( $(this).attr("data-image") ) {
				let source = $(this).attr("data-image-source");
				$("#image-preview").attr("src", source);
				$("#preview-filename").text($(this).text());
			}
		});
	});

</script>
@endsection
