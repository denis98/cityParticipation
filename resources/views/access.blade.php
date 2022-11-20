@extends('layouts.app')

@section('scripts')
	@vite('resources/sass/app.scss')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p>
                        Der Zugang zu dieser Seite ist eingeschränkt möglich.
												Das Projekt dient zur Demonstration eines Projektes für den hackatum-Hackathon.
												<br>
												Zum Zugang sind Cookies erforderlich.
												<br>
												Bitte hinterlassen Sie keine Personenbezogenen Daten auf diesem Portal, es wird auch keine funktionierende E-Mail-Adresse benötigt.
                    </p>
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['legitimate'],
                        ]) !!}

                        {!! Form::password('password', [
                            'class' => 'form-control mb-3',
                            'placeholder' => 'Passwort für dieses Portal'
                            ]) !!}

                        {!! Form::submit('Weiter', ['class' => 'btn btn-md btn-outline-primary d-block']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

</div>
@endsection
