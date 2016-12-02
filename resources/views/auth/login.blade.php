@extends('layouts.app')

@section('title')
	Connexion
@stop

@section('content')
	<h1>Se connecter</h1>
	<hr>
	<form action="{{ url('auth/login') }}" class="row" method="post">
			
		{{ csrf_field() }}

		<div class="form-group col-lg-8 col-lg-offset-2">
			<input class="form-control" type="text" name="email" placeholder="Adresse email" />
		</div>

		<div class="form-group col-lg-8 col-lg-offset-2">
			<input class="form-control" type="password" name="password" placeholder="Mot de passe" />
		</div>

		<div align="center" class="form-group col-lg-8 col-lg-offset-2">
			<button class="btn btn-primary col-lg-6 col-lg-offset-3">Connexion</button>
		</div>
	</form>

	<hr>

 	<a href="{{ url('help') }}"><span class="glyphicon glyphicon glyphicon-info-sign"></span> Je n'ai pas de compte, comment puis-je m'inscrire ?</a>
@stop