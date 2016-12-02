@extends('layouts.app')

@section('title')
	Événements
@stop

@section('content')

	<h1>Les événements à venir
        @if(Auth::check() && Auth::user()->level > 1) 
            <a title="Créer un événement" href="{{ url('events/create') }}" class="create-new create-event glyphicon glyphicon-plus title-btn-hover"></a>
        @endif</h1>
	</h1>

	<hr>

	@forelse($events as $e)
	<div class="news" data-id="{{$e->id}}">
		<h1><a href="{{ url('events/show/'.$e->id)}}">{{$e->name}}</a></h1>
		<p class="about-teams">
			@if($e->team_id > 0 && $e->team != null)
				<p><a href="{{ url('teams/show/'.$e->team->slug) }}">{{ $e->team->name }}</a></p>
			@endif
		</p>
		<p>{!! cut($e->article, 500) !!}</p>
		<p class="post-infos">Créé par <b>{!! printUserLink($e->user) !!}</b>. </p>
		<p class="post-infos">Début : {{$e->start->format('d/m/Y \à H:i')}}</b>. </p>
		<p class="post-infos">Fin : {{$e->end->format('d/m/Y \à H:i')}}</b>. </p>
	</div>
	@empty
		@if(isset($old))
			<h3 align="center">Aucun événement passé.</h3>
		@else
			<h3 align="center">Aucun événement à venir.</h3>
		@endif
	@endforelse

	<div align="right">{!! $events->render() !!}</div>

	<hr>
	
		<a class="see-all" href="{{ url('events/past') }}"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Voir les événements <u>passés</u></a><br>
	@if(isset($all))
		<a class="see-all" href="{{ url('events/coming') }}"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Ne voir que les événements <u>à venir</u> qui ne <u>concernent aucune team</u></a>
	@else
		<a class="see-all" href="{{ url('events/coming/all') }}"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Voir <u>tous</u> événements <u>à venir</u></a>
	@endif


@stop
