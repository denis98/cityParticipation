@extends('layouts.app')

@section('scripts')
	@vite(['resources/sass/app.scss', 'resources/js/newidea.js'])
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h2 class="mb-3 ps-3">New Idea</h2>
			<div class="card">
				<div class="card-body">
					<div class="row mb-4">
						<div class="col">
							<div id="map" class="map mb-2"></div>
							<div id="info" class="mb-3"></div>
						</div>
						<div class="col">
							{!! Form::open([
								'method' => 'POST',
								'route' => 'idea.store',
								'files' => true,
								]) !!}


								<p id="location-needed">
									You have to select an location in the map on the left.
								</p>

								<fieldset class="mb-3 form-floating">
								{!! Form::text('title', null, [
									'class' => 'form-control mb-3',
									'placeholder' => ''
									]) !!}
									{!! Form::label('title', 'Title') !!}
								</fieldset>

								<fieldset class="mb-3 form-floating">
								{!! Form::text('topic', null, [
									'class' => 'form-control mb-3',
									'placeholder' => ''
									]) !!}
									{!! Form::label('topic', 'Topic (optional)') !!}
								</fieldset>

								<fieldset class="mb-3 form-floating">
								{!! Form::textarea('description', null, [
									'class' => 'form-control mb-3',
									'placeholder' => ''
									]) !!}
								{!! Form::label('description', 'Explain your idea') !!}
								</fieldset>


								<fieldset class="mb-3">
								{!! Form::file('attachments[]', [
										'class' => 'form-control',
										'multiple' => true,
										]) !!}
										<p class="p-0 text-center">You can edit the filenames afterwards</p>
								</fieldset>

								{!! Form::hidden('coordinates', null, [
									'id' => 'h-coordinates',
									]) !!}
								{!! Form::hidden('location', null, [
									'id' => 'h-location',
									]) !!}

								{!! Form::submit('Submit', [
									'class' => 'btn btn-md btn-primary d-block w-100',
									'id' => 'submit_idea'
									]) !!}

								{!! Form::close() !!}

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
