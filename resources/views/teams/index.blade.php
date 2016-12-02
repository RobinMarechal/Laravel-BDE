@extends('layouts.app')

@section('title')
	Teams
@stop

@section('content')

<article class="content-editable editable">
    <h1 id="{{ $content->name.'_title' }}">
        {{ $content->title }}
        @if(Auth::check() && Auth::user()->level > 1) 
            <a title="Créer une team" href="{{ url('teams/create') }}" class="create-new create-team glyphicon glyphicon-plus title-btn-hover"></a>
        @endif
    </h1>
        {!! printButtonContent($content->name, ['id' => 'edit-content', 'data-id' => $content->id]) !!}

    <hr>

    <div id="{{ $content->name.'_content' }}" class="content-box">
        {!! $content->content !!}
    </div>

    <hr>

    <h2>Les teams :</h2>

    <ul class="team-list">   	
	    @forelse($teams as $t)
	    	<li>
                <a href="{{ url('teams/show/'.$t->slug) }}"> {{ $t->name }} </a> 
                @if($t->trashed())
                    <span title="Cette n'est visible que par ses responsables où par ceux du BDA." class="glyphicon glyphicon-exclamation-sign"></span>
                @endif
                {{-- &nbsp; - &nbsp; {!! printUserLink($t->user, 'manager') !!}--}}
            </li> 
	    @empty
	    	<p>Aucune team n'a été créée pour le moment.</p>
	    @endforelse
    </ul>

    <div align="right">{!! $teams->render() !!}</div>

</article>
@stop