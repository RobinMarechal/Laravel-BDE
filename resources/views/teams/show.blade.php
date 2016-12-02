<?php   
    $isManaging = Auth::check() && (Auth::user()->level > 2 || Auth::user()->isManaging($team));
?>

@extends('layouts.app')

@section('title')
	{{ $team->name }}
@stop

@section('content')

<div id="team">
    <article id="team-content" class="team-editable editable">
        <span id="suppressed-sign" title="Cette news a été supprimée et n'est visible que par les responsables du BDA ou de la team qu'elle concerne." class="glyphicon glyphicon-exclamation-sign suppressed {{ $team->trashed() ? '' : 'not-displayed' }}"></span>
        <h1 id="team_title">
            <span class="team-name">{{ $team->name }}</span>
        </h1>
        	@if($isManaging)
            	{!! printButtonContent($team->name, ['id' => 'edit-content', 'data-id' => $team->id]) !!}
                @if($team->trashed())
                    <button id="btn-toggle" title="Restaurer la team" data-id="{{ $team->id }}" data-url="teams/suppressRestore" class="btn btn-primary btn-edit untrash create-new glyphicon glyphicon-ok"></button>
                @else
                    <button id="btn-toggle" title="Supprimer la team" data-id="{{ $team->id }}" data-url="teams/suppressRestore" class="btn btn-primary btn-edit trash create-new glyphicon glyphicon-remove"></button>
                @endif
            @endif

        <hr>

        <div id="team_article" class="team-box">
            {!! $team->article !!}
        </div>

        <hr>

    </article>

    <h3>L'actu de la team &laquo; <span class="team-name">{{ $team->name }} </span> &raquo;
        @if($isManaging) 
            <a title="Publier une news pour cette Team" href="{{ url('news/create') }}" data-team_id="{{$team->id}}" data-team_name="{{$team->name}}" class="create-team-news glyphicon glyphicon-plus title-btn-hover"></a>
        @endif
    </h3>
    <hr>


        <div class="team-section team-news">

            @forelse($team->news as $n)

            <div class="news news-block" data-id="{{$n->id}}">
                <span id="suppressed-sign" title="Cette news a été supprimée et n'est visible que par les responsables du BDA ou de la team qu'elle concerne." class="glyphicon glyphicon-exclamation-sign suppressed {{ $n->trashed() ? '' : 'not-displayed' }}"></span>
                <h3><a href="{{ url('news/show/'.$n->id)}}">{{$n->title}}</a></h3>

                <p>{!!cut($n->content, 300)!!}</p>
                <p class="post-infos">Publiée le {{$n->published_at->format('d/m/Y')}} par <b>{!! printUserLink($n->user) !!}</b>. </p>
            </div>

            @empty
                <h4 align="center">Aucune news n'a été publiée.</h4>
            @endforelse

            <a href="{{ url('teams/show/'.$team->slug.'/news') }}" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>

        </div>

    <hr>

    <h3>Les événements à venir de la team &laquo; <span class="team-name">{{ $team->name }} </span> &raquo;
        @if($isManaging) 
            <a title="Créer un événement pour cette Team" href="{{ url('events/create') }}" data-team_id="{{$team->id}}" data-team_name="{{$team->name}}" class="create-team-event glyphicon glyphicon-plus title-btn-hover"></a>
        @endif
    </h3>
    <hr>

        <div class="team-section team-news">
            @forelse($team->events as $e)
            <div class="news" data-id="{{$e->id}}">
                <h1><a href="{{ url('news/show/'.$e->id)}}">{{$e->name}}</a></h1>
                <p>{!! cut($e->article, 500) !!}</p>
                <p class="post-infos">Créé par <b>{!! printUserLink($e->user) !!}</b>. </p>
                <p class="post-infos">Début : {{$e->start->format('d/m/Y \à H:i')}}</b>. </p>
                <p class="post-infos">Fin : {{$e->end->format('d/m/Y \à H:i')}}</b>. </p>
            </div>
            @empty
                <h4 align="center">Aucun événement à venir...</h4>
            @endforelse

            <a href="{{ url('teams/show/'.$team->slug.'/events') }}" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
        </div>

    <hr>
    <a class="see-all" href="{{ url('teams') }}"><span class="glyphicon glyphicon glyphicon-arrow-left"></span> Revenir a la liste des Teams</a>
</div>

@stop