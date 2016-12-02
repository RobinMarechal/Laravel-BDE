@extends('layouts.app')

@section('title')
	{{ $event->name }}
@stop

@section('content')
<article id="event-content" class="event-editable editable">
	<div class="event" data-id="{{$event->id}}">
		<span id="suppressed-sign" title="Cet événement a été supprimé et n'est visible que par les responsables du BDA ou de la team qu'il concerne." class="glyphicon glyphicon-exclamation-sign suppressed {{ $event->trashed() ? '' : 'not-displayed' }}"></span>
		<h1 id="event_name">
			<a href="{{ url('events/show/'.$event->id)}}">{{$event->name}}</a> 
		</h1>
		<hr>
	        @if(Auth::check() && (Auth::user()->level > 2 || ($event->team_id != NULL && Auth::user()->isManaging($event->team)) ) )
        		{!! printButtonContent($event->id, ['id' => 'edit-content', 'data-id' => $event->id]) !!}
	            @if($event->trashed())
	            	<button id="btn-toggle" title="Restaurer l'événement" data-id="{{ $event->id }}" data-url="events/suppressRestore" class="btn btn-primary btn-edit untrash create-new glyphicon glyphicon-ok"></button>
	            @else
	            	<button id="btn-toggle" title="Supprimer l'événement" data-id="{{ $event->id }}" data-url="events/suppressRestore" class="btn btn-primary btn-edit trash create-new glyphicon glyphicon-remove"></button>
		            @endif
	        @endif
		<p class="about-teams">
			@if($event->team != NULL)
				<p><a href="{{ url('teams/show/'.$event->team->slug) }}">{{ $event->team->name }}</a></p>
			@endif
		</p>
		<ul id="start-end">
			<li id="event_dates">
				Début : 
				<span id="event_start_date">{{ $event->start->format('d/m/Y') }}</span> à 
				<span id="event_start_time">{{ $event->start->format('H:i') }}</span>.
			</li>
			<li id="event_start">
				Fin : 
				<span id="event_end_date">{{ $event->end->format('d/m/Y') }}</span> à 
				<span id="event_end_time">{{ $event->end->format('H:i') }}</span>.
			</li>
		</ul>
		<div id="event_article">{!!$event->article!!}</div>
		<p class="post-infos">Publié {{-- le <span id="event_created_at">{{$event->created_at->format('d/m/Y \à H:i')}}</span> --}} par <b>{!! printUserLink($event->user) !!}</b>. </p>
	</div>
	@if($event->end->isPast())
	<div id="isPast">
		<hr>
		<span class="glyphicon glyphicon-calendar"></span> &nbsp; Cet événement est terminé.
	</div>
	@endif
</article>
@stop