@extends('layouts.app')

@section('title')
	Galerie d'images
@stop

@section('content')
	<h1>Galerie d'images
        @if(Auth::check() && Auth::user()->level > 1) 
	        <a title="Publier une ou plusieurs images" href="{{ url('gallery/post') }}" class="create-new create-pictures glyphicon glyphicon-plus title-btn-hover"></a>
        @endif
    </h1>
	<hr>

	<div id="pictures">
		@forelse($pictures as $p)
			<div class="picture-block" title="Cliquez pour voir l'image et ses informations" data-id="{{ $p->id }}">
				<img src="{{ url($p->path) }}">
			</div>
		@empty
			<h4 align="center"> Aucune image n'a été publiée pour le moment. </h4>
		@endforelse
		@forelse($pictures as $p)
			<div class="picture-block" data-id="{{ $p->id }}">
				<img src="{{ url($p->path) }}">
			</div>
		@empty
			<h4 align="center"> Aucune image n'a été publiée pour le moment. </h4>
		@endforelse
		@forelse($pictures as $p)
			<div class="picture-block" data-id="{{ $p->id }}">
				<img src="{{ url($p->path) }}">
			</div>
		@empty
			<h4 align="center"> Aucune image n'a été publiée pour le moment. </h4>
		@endforelse
		@forelse($pictures as $p)
			<div class="picture-block" data-id="{{ $p->id }}">
				<img src="{{ url($p->path) }}">
			</div>
		@empty
			<h4 align="center"> Aucune image n'a été publiée pour le moment. </h4>
		@endforelse
	</div>

	<div align="right">{!! $pictures->render() !!}</div>

@stop