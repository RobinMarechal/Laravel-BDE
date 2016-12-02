@extends('layouts.app')

@section('title')
	{{ $content->title }}
@stop

@section('content')
<article class="content-editable editable">
    <h1 id="{{ $content->name.'_title' }}">
        {{ $content->title }}
    </h1>
        {!! printButtonContent($content->name, ['id' => 'edit-content', 'data-id' => $content->id]) !!}

    <hr>

    <div id="{{ $content->name.'_content' }}" class="content-box">
        {!! $content->content !!}
    </div>
</article>
@stop