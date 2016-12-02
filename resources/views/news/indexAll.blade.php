@extends('layouts.app')

@section('title')
	News
@stop

@section('content')
	
	<h1>L'Actualité du BDA
        @if(Auth::check() && Auth::user()->level > 1) 
            <a title="Publier une news" href="{{ url('news/create') }}" class="create-new create-news glyphicon glyphicon-plus title-btn-hover"></a>
        @endif</h1></h1>
	<hr>

	@forelse($news as $n)
	<div class="news news-block" data-id="{{$n->news_id}}">
		<span id="suppressed-sign" title="Cette news a été supprimée et n'est visible que par les responsables du BDA ou de la team qu'elle concerne." class="glyphicon glyphicon-exclamation-sign suppressed {{ $n->news_deleted_at == NULL ? 'not-displayed' : '' }}"></span>
		<h1><a href="{{ url('news/show/'.$n->news_id)}}">{{$n->news_title}}</a></h1>
		<p class="about-teams">
			@if($n->team_id > 0 && $n->team_deleted_at == NULL)
				<p><a href="{{ url('teams/show/'.$n->team_slug) }}">{{ $n->team_name }}</a></p>
			@endif
		</p>
		<p>{!! cut($n->news_content, 500) !!}</p>
		<p class="post-infos">Publiée le {{(new Carbon\Carbon($n->news_published_at))->format('d/m/Y \à H:i')}} 
			par <b><a href="{{url('users/show/'.$n->user_id)}}">{{$n->user_first_name . ' ' . $n->user_last_name}}</a></b>.
		</p>
	</div>
	@empty
		<h3 align="center">Aucune news n'a été publiée.</h3>
	@endforelse

	<div align="right">{!! $news->render() !!}</div>

	<hr>

	<a class="see-all" href="{{ url('news') }}"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Masquer les news concernant les teams</a>

@stop
