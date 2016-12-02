@extends('layouts.app')

@section('title')
	{{ $news->title }}
@stop

@section('content')
<article id="news-content" class="news-editable editable">
	<div class="news" data-id="{{$news->id}}">
		<span id="suppressed-sign" title="Cette news a été supprimée et n'est visible que par les responsables du BDA ou de la team qu'elle concerne." class="glyphicon glyphicon-exclamation-sign suppressed {{ $news->trashed() ? '' : 'not-displayed' }}"></span>
		<h1 id="news_title">
			<a href="{{ url('news/show/'.$news->id)}}">{{$news->title}}</a> 
		</h1>
		<hr>
	        @if(Auth::check() && (Auth::user()->level > 2 || ($news->team_id != NULL && Auth::user()->isManaging($news->team)) ) )
        		{!! printButtonContent($news->id, ['id' => 'edit-content', 'data-id' => $news->id]) !!}
	            @if($news->trashed())
	            	<button id="btn-toggle" title="Restaurer la news" data-id="{{ $news->id }}" data-url="news/suppressRestore" class="btn btn-primary btn-edit untrash create-new glyphicon glyphicon-ok"></button>
	            @else
	            	<button id="btn-toggle" title="Supprimer la newsP" data-id="{{ $news->id }}" data-url="news/suppressRestore" class="btn btn-primary btn-edit trash create-new glyphicon glyphicon-remove"></button>
		            @endif
	        @endif
		<p class="about-teams">
			@if($news->team != NULL)
				<p><a href="{{ url('teams/show/'.$news->team->slug) }}">{{ $news->team->name }}</a></p>
			@endif
		</p>
		<div id="news_content">{!!$news->content!!}</div>
		<p class="post-infos">Publiée le <span id="news_published_at">{{$news->published_at->format('d/m/Y')}}</span> par <b>{!! printUserLink($news->user) !!}</b>. </p>
	</div>
	@if($news->published_at->isFuture())
	<div id="isFuture">
		<hr>
		<span class="glyphicon glyphicon-calendar"></span> &nbsp; Cette news sera publiée le {{ $news->published_at->format("d/m/Y") }}
	</div>
	@endif
</article>
@stop