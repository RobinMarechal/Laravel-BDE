@extends('layouts.app')

@section('title')
	News
@stop

@section('content')
	
	<h1>L'Actualité du BDA
        @if(Auth::check() && Auth::user()->level > 1) 
	        <a title="Publier une news" href="{{ url('news/create') }}" class="create-new glyphicon glyphicon-plus title-btn-hover"></a>
        @endif
    </h1>
	<hr>

	@forelse($news as $n)
	<div class="news news-block" data-id="{{$n->id}}">
		<span id="suppressed-sign" title="Cette news a été supprimée et n'est visible que par les responsables du BDA ou de la team qu'elle concerne." class="glyphicon glyphicon-exclamation-sign suppressed {{ $n->trashed() ? '' : 'not-displayed' }}"></span>
		<h1><a href="{{ url('news/show/'.$n->id)}}">{{$n->title}}</a></h1>
		<p class="about-teams">
			@if($n->team_id > 0 && $n->team != null)
				<p><a href="{{ url('teams/show/'.$n->team->slug) }}">{{ $n->team->name }}</a></p>
			@endif
		</p>
		{!! cut($n->content, 500) !!}
		<p class="post-infos">Publiée le {{$n->published_at->format('d/m/Y')}} par <b>{!! printUserLink($n->user) !!}</b>. </p>
	</div>
	@empty
		<h3 align="center">Aucune news n'a été publiée.</h3>
	@endforelse

	<div align="right">{!! $news->render() !!}</div>

	<hr>
	
	<a class="see-all" href="{{ url('news/all') }}"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Voir toutes les news</a>
@stop
