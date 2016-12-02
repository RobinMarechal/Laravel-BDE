<?php
    $banner_content = App\Content::where('name', 'banner_content')->first();
    $news = App\News::whereNull('team_id')->where('validated', '1')->where('published_at', '<=', DB::raw('NOW()'))->orderBy('published_at', 'DESC')->limit(5)->get();
    $events = App\Event::whereNull('team_id')->where('validated', '1')->where('start', '>=', DB::raw('NOW()'))->orderBy('start', 'ASC')->limit(5)->get();

    if($logged = Auth::check())
    {
        $nbOfNotifications = Auth::user()->getNbOfUnseenNotifications();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}" />    
    <link rel="stylesheet" type="text/css" href="{{url('/js/jQueryUI/jquery-ui.min.css')}}"></link>

    {{-- <link rel="stylesheet" type="text/css" href="{{url('/js/CKeditor/contents.css')}}" /> --}}
    <title>BDA | @section('title') BDA Polytech Tours @show </title>

    <base href="/">
</head>
<body ng-app="app">
    <header>

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <a class="navbar-brand" href="/">Bureau des Arts de Polytech Tours</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  
                    <ul class="nav navbar-nav navbar-right" ng-init="home='active'">
                        <li id="nav-home" class="hvr-underline-from-center"><a href="{{ url('/') }}">Accueil</a></li>
                        <li id="nav-teams" class="hvr-underline-from-center"><a href="{{ url('teams') }}"">Les Teams</a></li>
                        <li id="nav-news" class="hvr-underline-from-center"><a href="{{ url('news') }}"">L'Actu</a></li>
                        <li id="nav-events" class="hvr-underline-from-center"><a href="{{ url('events') }}"">Événements</a></li>
                        <li id="nav-staff" class="hvr-underline-from-center"><a href="{{ url('staff') }}"">Le Staff</a></li>
                        <li id="nav-gallery" class="hvr-underline-from-center"><a href="{{ url('gallery') }}"">Galerie d'Images</a></li>

                        @if(Auth::check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user"></span> 
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li id="nav-profile" title="Consultez votre profile">
                                        <a href="{{ url('users/show/'. Auth::user()->id) }}">
                                            <span class="glyphicon glyphicon-user"></span>
                                            {{Auth::user()->first_name . ' ' . Auth::user()->last_name}}
                                        </a>
                                    </li>
                                    <li id="nav-notifications" title="Voir les notifications">
                                        <a href="{{ url('notifications') }}">
                                            @if($nbOfNotifications > 0)
                                                <span class="nb-of-notifs">{{ $nbOfNotifications }}</span>
                                            @endif
                                            <span class="glyphicon glyphicon-bell"></span>
                                            Notifications
                                        </a>
                                    </li>
                                    <li id="nav-logout" title="Se déconnecter">
                                        <a href="{{ url('auth/logout') }}">
                                            <span class="glyphicon-log-out glyphicon" ></span>
                                            Se déconnecter
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li id="nav-login" title="Se connecter" class="hvr-underline-from-center">
                                <a class="glyphicon glyphicon-log-in" href="{{ url('auth/login') }}"></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <hr class="border"></hr>
        </nav>

        <div id="banner">
            <div class="panel banner-panel content-editable">
                {{-- <div ng-show="user.check != 1" title="Cliquez ici pour modifier le contenu" class="glyphicon glyphicon-pencil edit-content"></div> --}}
                {!! printButtonContent($banner_content->name, ['id' => 'banner-content-btn'], 'btn-edit-banner') !!}

                <div id="banner-content" data-name="{{ $banner_content->name }}">
                    <h1>{{ $banner_content->title }}</h1>
                    <p>{{ $banner_content->content }}</p>
                </div>

            </div>
        </div>

    <noscript>
        Ce site nécessite d'activer JavaScript pour fonctionner correctement.
    </noscript>

    </header>

    @include('flash::message')

    <div class="container-fluid page-content">
        <div class="content col-lg-8">
            <div class="inner">
                @yield('content')
            </div>
        </div>

        <aside class="content col-lg-4">
            <div class="inner">
                <section class="social-networks">
                    <h1>Suivez-nous</h1>
                    <div class="logos">
                        <a target="_BLANK" href="https://www.facebook.com/BDA-Polytech-Tours-233930700284519/"><img src="{{url('img/fb-logo.png')}}"></a>
                        <a target="_BLANK" href="https://www.youtube.com/channel/UCM9GF7SHxbyUzQUT6eJDPlw"><img src="{{url('img/yt-logo.png')}}"></a>
                    </div>

                </section>

                <hr class="separator">

                <section class="lastest-news">
                    <h1>Dernières news 
                        @if(Auth::check() && Auth::user()->level > 1) 
                            <a title="Ajouter une news" href="{{ url('news/create') }}" class="create-new create-news glyphicon glyphicon-plus btn-hover"></a>
                        @endif
                    </h1>
                    @if($news->count() > 0)
                        @foreach($news as $n)
                            <a href="/news/show/{{$n->id}}">{{$n->title}}</a>
                            <p class="date">{{$n->published_at->format('d/m/Y')}}</p>
                        @endforeach

                        <a href="/news" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
                    @else
                        <p>Aucune news récente.</p>
                    @endif

                 </section>

                 <hr class="separator">

                <section class="incoming-events">
                    <h1>Événements à venir
                        @if(Auth::check() && Auth::user()->level > 1) 
                            <a title="Ajouter un événement" href="{{ url('events/create') }}" class="create-new create-event glyphicon glyphicon-plus btn-hover"></a>
                        @endif
                    </h1>
                     @if($events->count() > 0)
                        @foreach($events as $e)
                            <a 
                                title="{{($today = $e->start->isToday()) ? 'Cet événement à lieu aujourd\'hui !' : 'Cliquez ici pour en savoir plus.'}}" 
                                    {{ $today ? 'class=today' : '' }} 
                                    href="/events/show/{{$e->id}}">{{$e->name}}
                            </a>
                            <p class="date {{ $today ? 'today' : '' }} ">
{{--                                 @if($e->start->dayOfYear == $e->end->dayOfYear)
                                    Le {{$e->start->format('d/m/Y\, \d\e H:i').' à '.$e->end->format('H:i')}}
                                @else
                                    Du {{$e->start->format('d/m').' au '.$e->end->format('d/m Y').', de '.$e->start->format('H:i').' à '.$e->end->format('H:i')}}
                                @endif --}}
                                Début : {{ $e->start->format('d/m/Y \à H:i') }} <br />Fin : {{ $e->end->format('d/m/Y \à H:i') }}
                            </p>
                        @endforeach

                        <a href="/events" align="right" class="see-all"><p>Tout voir <span class="glyphicon glyphicon-arrow-right"></span></p></a>
                    @else
                        <p>Aucun événement à venir.</p>
                    @endif
                    
                </section>
            </div>
        </aside>
    </div>

    <script src="{{url('/js/jquery.min.js')}}"></script>
    <script src="{{url('/js/bootstrap.min.js')}}"></script>
    <script src="{{url('/js/bootbox.min.js')}}"></script>
    <script src="{{url('/js/CKeditor/ckeditor.js')}}"></script>
    <script src="{{url('/js/scripts/nav-active.js')}}"></script>
    <script src="{{url('/js/jQueryUI/jquery-ui.min.js')}}"></script>

    <script type="text/javascript">

    /**
    *   display a flash alert which fades out after 2s 
    *   @var msg
    *   @var type (default: "danger") : alert type
    */
    function flashMessage(msg, type="danger")
    {
        var html = '<div title="Cliquez pour masquer le message" id="alert" class="alert js-alert alert-'+type+'">'+msg+'</div>';
        $('#alert').remove();
        $('body').append(html);
        $('#alert.js-alert').animate({'opacity': '+0.9'}, 200 );
        $('#alert.js-alert').delay(1500).animate({'opacity': '-1.2'}, 1000, function(){
            $(this).remove();
        });
    }

    function flashSuccess() 
    {
        var html = '<div id="alert" class="js-alert-success alert-sucess"><span class="glyphicon glyphicon-ok flash"></span></div>';
        $('.js-alert-success').remove();
        $('body').append(html);
        $('#alert.js-alert-success').animate({'opacity': '+0.8'}, 350 );
        $('#alert.js-alert-success').delay(500).animate({'opacity': '-1.2'}, 550, function(){
            $(this).remove();
        });
    }

    function diffDates(date1, date2)
    {
        var date1Str = date1.split(' ');
        date1Str[0] = date1Str[0].split('-'),
        date1Str[1] = date1Str[1].split(':');

        var date2Str = date2.split(' ');
        date2Str[0] = date2Str[0].split('-'),
        date2Str[1] = date2Str[1].split(':');

        d1Str = date1Str[0][2]+'-'+date1Str[0][1]+'-'+date1Str[0][0]+' '+date1Str[1][0]+':'+date1Str[1][1];
        d2Str = date2Str[0][2]+'-'+date2Str[0][1]+'-'+date2Str[0][0]+' '+date2Str[1][0]+':'+date2Str[1][1];

        return d1Str < d2Str ? -1 : d1Str == d2Str ? 0 : 1;
    }

    $('.alert').on('click', function(){
        $(this).animate({'opacity': '-1.2'}, 800 , function(){
            $(this).remove();
        });
    });

    $(function()
    {
        $('.alert').delay(3000).animate({'opacity': '-1.2'}, 800 , function(){
            $(this).remove();
        });
    });

    CONTENT = {
        getContent: function(name)
        {
            return $.get('contents/'+name);
        },
        update: function(name, data)
        {
            var promise = this.sendData(name, data);

            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    $('h1#'+name+'_title').html(data2.title);
                    $('div#'+name+'_content').html(data2.content);
                    flashMessage('Les données ont bien été modifiées !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },
        updateBanner: function(name, data)
        {
            var promise = this.sendData(name, data);

            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    $('#banner-content h1').html(data2.title);
                    $('#banner-content p').html(data2.content);
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        sendData: function(name, data)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            return $.ajax({
                method: 'POST',
                url: 'contents/post',
                data: {
                    name: name,
                    title: data.title,
                    content: data.content,
                }
            });
        }
    }

    TEAM = {
        getTeam: function(id)
        {
            return $.get('teams/'+id);
        },

        update: function(id, data)
        {
            data.id = id;
            var promise = this.sendData('teams/post', data);

            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    $('.team-name').html(data2.name);
                    $('div#team_article').html(data2.article);
                    $('title').html('BDA | '+data2.name);
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },
        
        trash: function(id)
        {
            var promise = this.sendData('teams/trash', {id: id});

            promise.done(function(data2)
            {
                if(data2 == true)
                {
                    $('#btn-toggle').attr('title', 'Restaurer la team');
                    $('#btn-toggle').removeClass('glyphicon-remove');
                    $('#btn-toggle').addClass('glyphicon-ok');
                    $('#btn-toggle').removeClass('trash');
                    $('#btn-toggle').addClass('untrash');
                    $('#suppressed-sign').removeClass('not-displayed');
                    flashMessage('La team a bien été supprimée !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        restore: function(id)
        {
            var promise = this.sendData('teams/restore', {id: id});

            promise.done(function(data2)
            {
                if(data2 == true)
                {
                    $('#btn-toggle').attr('title', 'Supprimer la news');
                    $('#btn-toggle').removeClass('glyphicon-ok');
                    $('#btn-toggle').addClass('glyphicon-remove');
                    $('#btn-toggle').removeClass('untrash');
                    $('#btn-toggle').addClass('trash');
                    $('#suppressed-sign').addClass('not-displayed');
                    flashMessage('La team a bien été restorée !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        create: function(data)
        {
            var promise = this.sendData('teams/ajax/create', data);
            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    flashMessage('La team a bien été créée !', 'success');
                    window.location.replace("teams/show/"+data2.slug);
                }
                else
                {
                    flashMessage('Impossible de créer la team. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2)
            {
                flashMessage('Impossible de créer la team. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        sendData: function(url, data)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            return $.ajax({
                method: 'POST',
                // url: 'teams/post',
                url: url,
                data: data,
                // data: {
                //     id: id,
                //     name: data.name,
                //     article: data.article,
                // }
            });
        }
    }

    // Click sur le bouton de la banière.    
    $('#banner-content-btn').click(function()
    {
        CONTENT.getContent('banner_content').done(function(content)
            {
                bootbox.dialog({
                    message: '<div class="form-group">'+
                                '<label class="label-control">Titre :</label>'+
                                '<input class="form-control" type="text" name="title" id="banner-title" value="'+content.title+'" />'+
                                '</div>'+
                                '<label class="label-control">Texte :</label>'+
                                '<textarea rows="10" class="form-control" id="banner-text" name="content">'+content.content+'</textarea>',
                    title: "Modifier le texte de la bannière",
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        cancel: {
                            label: "Annuler",
                            className: "btn-default",
                        },
                        validate: {
                            label: "Valider",
                            className: "btn-primary",
                            callback: function() {
                                var data = {
                                    title: $('#banner-title').val(),
                                    content: $('#banner-text').val(),
                                }
                                CONTENT.updateBanner('banner_content', data);

                            }
                        }
                    }
                });
            });

        })

    // Click sur un autre bouton de modification de contenu
    $('.content-editable #edit-content').click(function(){
        var id = $(this).data('id'),
            name = $(this).data('name');

        CONTENT.getContent(name).done(function(content)
        {
            bootbox.dialog({
                message: '<div class="form-group">'+
                            '<label class="label-control">Titre :</label>'+
                            '<input class="form-control" type="text" name="title" id="'+name+'_edit_title" value="'+content.title+'" />'+
                            '</div>'+
                            '<label class="label-control">Texte :</label>'+
                            '<textarea class="form-control" id="ck_content_'+name+'" name="ck_content_'+name+'">'+content.content+'</textarea>',
                title: "Modifier un contenu",
                backdrop: true,
                buttons: {
                    cancel: {
                        label: "Annuler",
                        className: "btn-default",
                    },
                    validate: {
                        label: "Valider",
                        className: "btn-primary",
                        callback: function() {
                            var data = {
                                title: $('#'+name+'_edit_title').val(),
                                content: CKEDITOR.instances['ck_content_'+name].getData(),
                            }
                            CONTENT.update(name, data);
                        }
                    }
                }
            });
            CKEDITOR.replace('ck_content_'+name);
        });

    }); 

    // Click sur un bouton de modification de Team
    $('.team-editable #edit-content').click(function(){
        var id = $(this).data('id'),
            name = $(this).data('name');

        TEAM.getTeam(id).done(function(team)
        {
            bootbox.dialog({
                message: '<div class="form-group">'+
                            '<label class="label-control">Titre :</label>'+
                            '<input class="form-control" type="text" name="title" id="'+id+'_edit_title" value="'+team.name+'" />'+
                            '</div>'+
                            '<label class="label-control">Texte :</label>'+
                            '<textarea class="form-control" id="ck_content_'+name+'" name="ck_content_'+name+'">'+team.article+'</textarea>',
                title: "Modifier un contenu",
                backdrop: true,
                buttons: {
                    cancel: {
                        label: "Annuler",
                        className: "btn-default",
                    },
                    validate: {
                        label: "Valider",
                        className: "btn-primary",
                        callback: function() {
                            var data = {
                                name: $('#'+id+'_edit_title').val(),
                                article: CKEDITOR.instances['ck_content_'+name].getData(),
                            }
                            TEAM.update(id, data);
                        }
                    }
                }
            });
            CKEDITOR.replace('ck_content_'+name);
        });

    });

    NEWS = {
        trash: function(id)
        {
            var promise = this.sendData('news/trash', {id: id});

            promise.done(function(data2)
            {
                if(data2 == true)
                {
                    $('#btn-toggle').attr('title', 'Restaurer la news');
                    $('#btn-toggle').removeClass('glyphicon-remove');
                    $('#btn-toggle').addClass('glyphicon-ok');
                    $('#btn-toggle').removeClass('trash');
                    $('#btn-toggle').addClass('untrash');
                    $('#suppressed-sign').removeClass('not-displayed');
                    flashMessage('La news a bien été supprimée !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        restore: function(id)
        {
            var promise = this.sendData('news/restore', {id: id});

            promise.done(function(data2)
            {
                if(data2 == true)
                {
                    $('#btn-toggle').attr('title', 'Supprimer la news');
                    $('#btn-toggle').removeClass('glyphicon-ok');
                    $('#btn-toggle').addClass('glyphicon-remove');
                    $('#btn-toggle').removeClass('untrash');
                    $('#btn-toggle').addClass('trash');
                    $('#suppressed-sign').addClass('not-displayed');
                    flashMessage('La news a bien été restorée !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        getData: function(id)
        {
            return $.get('news/'+id);
        },

        sendData: function(url, data)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            return $.ajax({
                method: 'POST',
                url: url,
                data: data,
            });
        },

        create: function(data)
        {
            var promise = this.sendData('news/create', data);
            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    flashMessage('La news a bien été créée !', 'success');
                    window.location.replace("news/show/"+data2.id);
                }
                else
                {
                    flashMessage('Impossible de créer la news. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2)
            {
                flashMessage('Impossible de créer la news. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        update: function(data)
        {
            var promise = this.sendData('news/update', data);
            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    $('#news_title>a').html(data2.title);
                    $('#news_content').html(data2.content);

                    var dateStr = data2.published_at.split(' ')[0],
                        dateTab = dateStr.split('-'),
                        y = dateTab[0],
                        m = dateTab[1],
                        d = dateTab[2];

                    var now = (new Date()).toISOString().substring(0, 10);
                    var isFuture = (dateStr > now);

                    if(isFuture)
                    {
                        $('#news-content').append('<div id="isFuture"><hr><span class="glyphicon glyphicon-calendar"></span> &nbsp; Cette news sera publiée le '+ d+'/'+m+'/'+y +' </div>')
                    }
                    else
                    {
                        $('#isFuture').remove();
                    }

                    $('#news_published_at').html(d+'/'+m+'/'+y);
                    flashMessage('La news a bien été modifiée !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier la news. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2)
            {
                flashMessage('Impossible de modifier la news. Si le problème persiste, contactez l\'administrateur.');
            });
        }
    }

    EVENT = {
        trash: function(id)
        {
            var promise = this.sendData('events/trash', {id: id});

            promise.done(function(data2)
            {
                if(data2 == true)
                {
                    $('#btn-toggle').attr('title', 'Restaurer l\'événement');
                    $('#btn-toggle').removeClass('glyphicon-remove');
                    $('#btn-toggle').addClass('glyphicon-ok');
                    $('#btn-toggle').removeClass('trash');
                    $('#btn-toggle').addClass('untrash');
                    $('#suppressed-sign').removeClass('not-displayed');
                    flashMessage('L\'événement a bien été supprimé !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        restore: function(id)
        {
            var promise = this.sendData('events/restore', {id: id});

            promise.done(function(data2)
            {
                if(data2 == true)
                {
                    $('#btn-toggle').attr('title', 'Supprimer l\'événement');
                    $('#btn-toggle').removeClass('glyphicon-ok');
                    $('#btn-toggle').addClass('glyphicon-remove');
                    $('#btn-toggle').removeClass('untrash');
                    $('#btn-toggle').addClass('trash');
                    $('#suppressed-sign').addClass('not-displayed');
                    flashMessage('L\'événement a bien été restoré !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2){
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        getData: function(id)
        {
            return $.get('events/'+id);
        },

        sendData: function(url, data)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            return $.ajax({
                method: 'POST',
                url: url,
                data: data,
            });
        },

        create: function(data)
        {
            var promise = this.sendData('events/ajax/create', data);
            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    flashMessage('L\'événement a bien été créé !', 'success');
                    window.location.replace("events/show/"+data2.id);
                }
                else
                {
                    flashMessage('Impossible de créer l\'événement. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2)
            {
                flashMessage('Impossible de créer l\'événement. Si le problème persiste, contactez l\'administrateur.');
            });
        },

        update: function(data)
        {
            var promise = this.sendData('events/update', data);
            promise.done(function(data2)
            {
                if(data2 != false)
                {
                    $('#event_name>a').html(data2.name);
                    $('#event_article').html(data2.article);

                    var startStr = data2.start,
                        endStr   = data2.end;

                    var start = startStr.split(' ');
                    start[0] = start[0].split('-');
                    start[1] = start[1].split(':');
                    
                    var end = endStr.split(' ');
                    end[0] = end[0].split('-');
                    end[1] = end[1].split(':');

                    console.log(start);
                    console.log(end);

                    var now = (new Date()).toISOString();
                    var isPast = (endStr < now);

                    $('#event_start_date').html(start[0][2]+'/'+start[0][1]+'/'+start[0][0]);
                    $('#event_start_time').html(start[1][0]+':'+start[1][1]);
                    $('#event_end_date').html(end[0][2]+'/'+end[0][1]+'/'+end[0][0]);
                    $('#event_end_time').html(end[1][0]+':'+end[1][1]);

                    if(isPast)
                    {
                        $('#event-content').append('<div id="isPast"><hr><span class="glyphicon glyphicon-calendar"></span> &nbsp; Cet événement a déjà eu lieu. </div>')
                    }
                    else
                    {
                        $('#isPast').remove();
                    }

                    flashMessage('L\'événement a bien été modifié !', 'success');
                }
                else
                {
                    flashMessage('Impossible de modifier l\'événement. Si le problème persiste, contactez l\'administrateur.');
                }
            });

            promise.fail(function(data2)
            {
                flashMessage('Impossible de modifier l\'événement. Si le problème persiste, contactez l\'administrateur.');
            });
        }
    }

    $('#news-content #btn-toggle').click(function()
    {
        var trashed = $(this).hasClass('untrash');
        var id = $(this).data('id');

        if(trashed)
        { 
            NEWS.restore(id);
        }
        else
        {
            NEWS.trash(id);
        }
    });

    $('#event-content #btn-toggle').click(function()
    {
        var trashed = $(this).hasClass('untrash');
        var id = $(this).data('id');

        if(trashed)
        { 
            EVENT.restore(id);
        }
        else
        {
            EVENT.trash(id);
        }
    });

    $('#team-content #btn-toggle').click(function()
    {
        var trashed = $(this).hasClass('untrash');
        var id = $(this).data('id');

        if(trashed)
        { 
            TEAM.restore(id);
        }
        else
        {
            TEAM.trash(id);
        }

    });

    USER = {
        teamManaged: function()
        {
            return this.getData('users/teamManaged');
        },

        getData: function(url='users/getData')
        {
            return $.get(url);
        },

        getUserData: function(id, wanted)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            return $.ajax({
                method: 'POST',
                url: 'users/data',
                data: {
                    id: id,
                    wanted: wanted,
                }
            }); 
        }
    }

    $('.create-news').click(function(ev)
    {
        ev.preventDefault();

        var promise = USER.teamManaged();
        promise.done(function(data)
        {
            var htmlTeams = '';

            htmlTeams += '<select class="form-control" name="create-news-team_id" id="create-news-team_id">';
            htmlTeams +=     '<option selected value="0"> Aucune </option>';
            for(var i=0; i<data.length; i++)
            {
                htmlTeams += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            htmlTeams += '</select>';



            bootbox.dialog({
                message: '  <div class="form-group">'+
                                '<label class="label-control">Team concernée : <span class="info-hover" title="Si cette news concerne le BDA dans sa totalité, sélectionnez \'Aucune\', sinon sélectionnez la team concernée.">?</span></label>'+
                                htmlTeams +
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Titre :</label>'+
                                '<input required class="form-control" type="text" name="create-news-title" id="create-news-title" placeholder="Titre de la news" />'+
                            '</div>'+
                            '<label class="label-control">Contenu :</label>'+
                            '<div class="form-group">'+
                                '<textarea required class="form-control" id="create-news-content" name="create-news-content"></textarea>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Date de publication : <span class="info-hover" title="Il est possible de programmer la publication d\'une news en indiquant une date future.">?</span></label>'+
                                '<input class="form-control" type="text" name="create-news-published_at" id="create-news-published_at" />'+
                            '</div>',
                title: "Publier une news",
                backdrop: true,
                buttons: {
                    cancel: {
                        label: "Annuler",
                        className: "btn-default",
                    },
                    validate: {
                        label: "Valider",
                        className: "btn-primary",
                        callback: function(e) {
                            var formData = {
                                title: $('#create-news-title').val(),
                                content: CKEDITOR.instances['create-news-content'].getData(),
                                published_at: $('#create-news-published_at').val(),
                                team_id: $('#update-news-team_id').val(),
                            }

                            if(formData.title == "" || formData.content == "")
                                flashMessage("La news n'a pas été publiée :\nvous devez remplir au moins le titre et le contenu de la news.");
                            else
                                NEWS.create(formData);

                        }
                    }
                }
            });
            CKEDITOR.replace('create-news-content');

            var date = new Date(),
                d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();

            d = d < 10 ? '0'+d : d;
            m = m < 10 ? '0'+m : m;

            $('#create-news-published_at').val(d+'-'+m+'-'+y);
                
            $('#create-news-published_at').datepicker({dateFormat: "dd-mm-yy", minDate: new Date(y, m, d)});
        });
        
        promise.fail(function(data2){
            flashMessage('Une erreur est survenue, veuillez recharger la page. \n Si le problème persiste, contactez l\'administrateur.');
            return [];
        });

    });    

    // Click sur un bouton de modification de news
    $('.news-editable #edit-content').click(function(){
        var id = $(this).data('id');

        NEWS.getData(id).done(function(news)
        {
            bootbox.dialog({
                message:    '<div class="form-group">'+
                                '<label class="label-control">Titre :</label>'+
                                '<input required class="form-control" type="text" name="update-news-title" id="update-news-title" value="' + news.title + '" />'+
                            '</div>'+
                            '<label class="label-control">Contenu :</label>'+
                            '<div class="form-group">'+
                                '<textarea required class="form-control" id="update-news-content" name="update-news-content">' + news.content + '</textarea>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Date de publication : <span class="info-hover" title="Il est possible de programmer la publication d\'une news en indiquant une date future.">?</span></label>'+
                                '<input class="form-control" type="text" name="update-news-published_at" id="update-news-published_at" />'+
                            '</div>',
                title: "Modifier une news",
                buttons: {
                    cancel: {
                        label: "Annuler",
                        className: "btn-default",
                    },
                    validate: {
                        label: "Valider",
                        className: "btn-primary",
                        callback: function(e) {
                            var formData = {
                                title: $('#update-news-title').val(),
                                content: CKEDITOR.instances['update-news-content'].getData(),
                                published_at: $('#update-news-published_at').val(),
                                id: news.id
                            }

                            if(formData.title == "" || formData.content == "")
                                flashMessage("La news n'a pas été modifiée :\nvous devez remplir au moins le titre et le contenu de la news.");
                            else
                                NEWS.update(formData);
                        }
                    }
                }
            });
            CKEDITOR.replace('update-news-content');

            var dateStr = news.published_at.split(' ')[0],
                dateTab = dateStr.split('-'),
                y = dateTab[0],
                m = dateTab[1],
                d = dateTab[2];

            $('#update-news-published_at').datepicker({dateFormat: "dd-mm-yy"});

            $('#update-news-published_at').val(d+'-'+m+'-'+y);
                

        });

    }); 

    // Click sur un bouton de modification de news
    $('.event-editable #edit-content').click(function(){
        var id = $(this).data('id');

        EVENT.getData(id).done(function(event)
        {
            bootbox.dialog({
                message:    '<div class="form-group">'+
                                '<label class="label-control">Nom de l\'événement :</label>'+
                                '<input required class="form-control" type="text" name="update-event-name" id="update-event-name" value="' + event.name + '" />'+
                            '</div>'+
                            '<label class="label-control">Contenu :</label>'+
                            '<div class="form-group">'+
                                '<textarea required class="form-control" id="update-event-article" name="update-event-article">' + event.article + '</textarea>'+
                            '</div><br />'+
                            '<div class="form-group">'+
                                '<label class="label-control">Date de début de l\'événement : </label>'+
                                '<input class="form-control" type="text" name="update-event-start-date" id="update-event-start-date" />'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Heure de début de l\'événement : <span class="label-info">(Format : H:Min, ex : 22:30)</span> </label>'+
                                '<input class="form-control" type="text" name="update-event-start-time" id="update-event-start-time" />'+
                            '</div><br />'+
                            '<div class="form-group">'+
                                '<label class="label-control">Date de fin de l\'événement : </label>'+
                                '<input class="form-control" type="text" name="update-event-end-date" id="update-event-end-date" />'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Heure de fin de l\'événement : <span class="label-info">(Format : H:Min, ex : 22:30)</span> </label>'+
                                '<input class="form-control" type="text" name="update-event-end-time" id="update-event-end-time" />'+
                            '</div>',
                title: "Créer un événement",
                backdrop: true,
                buttons: {
                    cancel: {
                        label: "Annuler",
                        className: "btn-default",
                    },
                    validate: {
                        label: "Valider",
                        className: "btn-primary",
                        callback: function(e) {
                            var start = $('#update-event-start-date').val()+' '+$('#update-event-start-time').val()+':00';
                            var end = $('#update-event-end-date').val()+' '+$('#update-event-end-time').val()+':00';

                            var formData = {
                                name: $('#update-event-name').val(),
                                article: CKEDITOR.instances['update-event-article'].getData(),
                                startStr: start,
                                endStr: end,
                                id: event.id
                            };

                            if(formData.name == "" || formData.article == "" || diffDates(start, end) > -1)
                                flashMessage("L\'événement n'a pas été modifié :\nvous devez remplir au moins le nom et l\'article de l'événement.");
                            else
                                EVENT.update(formData);
                        }
                    }
                }
            });
            CKEDITOR.replace('update-event-article');

            var startStr = event.start,
                endStr   = event.end;

            var start = startStr.split(' ');
            start[0] = start[0].split('-');
            start[1] = start[1].split(':');
            var end   = endStr.split(' ');
            end[0] = end[0].split('-');
            end[1] = end[1].split(':');

            $('#update-event-start-date').val(start[0][2]+'-'+start[0][1]+'-'+start[0][0]);
            $('#update-event-start-time').val(start[1][0]+':'+start[1][1]);
            $('#update-event-end-date').val(end[0][2]+'-'+end[0][1]+'-'+end[0][0]);
            $('#update-event-end-time').val(end[1][0]+':'+end[1][1]);

            $('#update-event-start-date').datepicker({dateFormat: "dd-mm-yy"});
            $('#update-event-end-date').datepicker({dateFormat: "dd-mm-yy"});               

        });

    });

    $('.create-event').click(function(ev)
    {
        ev.preventDefault();

        var promise = USER.teamManaged();
        promise.done(function(data)
        {
            var htmlTeams = '';

            htmlTeams += '<select class="form-control" name="create-event-team_id" id="create-event-team_id">';
            htmlTeams +=     '<option selected value="0"> Aucune </option>';
            for(var i=0; i<data.length; i++)
            {
                htmlTeams += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            htmlTeams += '</select>';

            bootbox.dialog({
                message: '  <div class="form-group">'+
                                '<label class="label-control">Team concernée : <span class="info-hover" title="Si cet événement concerne le BDA dans sa totalité, sélectionnez \'Aucune\', sinon sélectionnez la team concernée.">?</span></label>'+
                                htmlTeams +
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Nom de l\'événement :</label>'+
                                '<input required class="form-control" type="text" name="create-event-name" id="create-event-name" placeholder="Nom de l\'événement" />'+
                            '</div>'+
                            '<label class="label-control">Présentation :</label>'+
                            '<div class="form-group">'+
                                '<textarea required class="form-control" id="create-event-article" name="create-event-article"></textarea>'+
                            '</div><br />'+
                            '<div class="form-group">'+
                                '<label class="label-control">Date de début de l\'événement : </label>'+
                                '<input class="form-control" type="text" name="create-event-start-date" id="create-event-start-date" />'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Heure de début de l\'événement : <span class="label-info">(Format : H:Min, ex : 22:30)</span> </label>'+
                                '<input class="form-control" type="text" name="create-event-start-time" id="create-event-start-time" />'+
                            '</div><br />'+
                            '<div class="form-group">'+
                                '<label class="label-control">Date de fin de l\'événement : </label>'+
                                '<input class="form-control" type="text" name="create-event-end-date" id="create-event-end-date" />'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="label-control">Heure de fin de l\'événement : <span class="label-info">(Format : H:Min, ex : 22:30)</span> </label>'+
                                '<input class="form-control" type="text" name="create-event-end-time" id="create-event-end-time" />'+
                            '</div>',
                title: "Créer un événement",
                backdrop: true,
                buttons: {
                    cancel: {
                        label: "Annuler",
                        className: "btn-default",
                    },
                    validate: {
                        label: "Valider",
                        className: "btn-primary",
                        callback: function(e) {
                            var start = $('#create-event-start-date').val()+' '+$('#create-event-start-time').val()+':00';
                            var end = $('#create-event-end-date').val()+' '+$('#create-event-end-time').val()+':00';

                            var formData = {
                                name: $('#create-event-name').val(),
                                article: CKEDITOR.instances['create-event-article'].getData(),
                                startStr: start,
                                endStr: end,
                            };

                            if(formData.name == "" || formData.article == "")
                                flashMessage("L\'événement n'a pas été modifié :\nvous devez remplir au moins le nom et l\'article de l'événement.");
                            else if(diffDates(start, end) > -1)
                                flashMessage("L\'événement n'a pas été modifié :\nLa date de début doit être antérieure à la date de fin.");
                            else
                                EVENT.create(formData);
                        }
                    }
                }
            });
            CKEDITOR.replace('create-event-article');

            var now = (new Date()).toISOString();


            var dateNow = now.split('T')[0];
            var timeNow = now.split('T')[1].substring(0,8);
            var date = [[],[]];
            date[0] = dateNow.split('-');
            date[1] = timeNow.split(':');
            console.log(date);

            $('#create-event-start-date').val(date[0][2]+'-'+date[0][1]+'-'+date[0][0]);
            $('#create-event-start-time').val(date[1][0]+':'+date[1][1]);
            $('#create-event-end-date').val(date[0][2]+'-'+date[0][1]+'-'+date[0][0]);
            $('#create-event-end-time').val(date[1][0]+':'+date[1][1]);

            $('#create-event-start-date').datepicker({dateFormat: "dd-mm-yy"});
            $('#create-event-end-date').datepicker({dateFormat: "dd-mm-yy"});  
        });
        
        promise.fail(function(data2){
            flashMessage('Une erreur est survenue, veuillez recharger la page. \n Si le problème persiste, contactez l\'administrateur.');
            return [];
        });

    });

    $('.create-team').click(function(ev)
    {
        ev.preventDefault();

        var promise = USER.getData();
        promise.done(function(user)
        {

            if(user != false)
            {
                bootbox.dialog({
                    message: '  <div class="form-group">'+
                                    '<label class="label-control">Nom de la Team :</label>'+
                                    '<input required class="form-control" type="text" name="create-team-name" id="create-team-name" placeholder="Nom de la Team" />'+
                                '</div>'+
                                '<label class="label-control">Présentation :</label>'+
                                '<div class="form-group">'+
                                    '<textarea required class="form-control" id="create-team-article" name="create-team-article"></textarea>'+
                                '</div>',
                    title: "Créer une Team",
                    backdrop: true,
                    buttons: {
                        cancel: {
                            label: "Annuler",
                            className: "btn-default",
                        },
                        validate: {
                            label: "Valider",
                            className: "btn-primary",
                            callback: function(e) {

                                var formData = {
                                    name: $('#create-team-name').val(),
                                    article: CKEDITOR.instances['create-team-article'].getData(),
                                };

                                if(formData.name == "" || formData.article == "")
                                    flashMessage("L\'événement n'a pas été modifié :\nvous devez remplir au moins le nom et l\'article de l'événement.");
                                else
                                    TEAM.create(formData);
                            }
                        }
                    }
                });
                CKEDITOR.replace('create-team-article');
            }
            else
            {
                flashMessage('Vous devez être connecté pour effectuer ceci.');
            }
        });
        
        promise.fail(function(data2){
            flashMessage('Une erreur est survenue, veuillez recharger la page. \n Si le problème persiste, contactez l\'administrateur.');
            return [];
        });

    });

    $('.create-team-event').click(function(ev)
    {
        ev.preventDefault();
        var team_id = $(this).data('team_id'),
            team_name = $(this).data('team_name');
    });

    $('.create-team-news').click(function(ev)
    {
        ev.preventDefault();
        var team_id = $(this).data('team_id'),
            team_name = $(this).data('team_name');

            console.log(team_name);

        bootbox.dialog({
            message: '  <div class="form-group">'+
                            '<label class="label-control">Team concernée : </label>'+
                            '<input type="text" class="form-control" disabled value="'+team_name+'" />' +
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="label-control">Titre de la News :</label>'+
                            '<input required class="form-control" type="text" name="create-news-title" id="create-news-title" placeholder="Titre de la news" />'+
                        '</div>'+
                        '<label class="label-control">Contenu :</label>'+
                        '<div class="form-group">'+
                            '<textarea required class="form-control" id="create-news-content" name="create-news-content"></textarea>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="label-control">Date de publication : <span class="info-hover" title="Il est possible de programmer la publication d\'une news en indiquant une date future.">?</span></label>'+
                            '<input class="form-control" type="text" name="create-news-published_at" id="create-news-published_at" />'+
                        '</div>',
            title: "Publier une news",
            backdrop: true,
            buttons: {
                cancel: {
                    label: "Annuler",
                    className: "btn-default",
                },
                validate: {
                    label: "Valider",
                    className: "btn-primary",
                    callback: function(e) {
                        var formData = {
                            title: $('#create-news-title').val(),
                            content: CKEDITOR.instances['create-news-content'].getData(),
                            published_at: $('#create-news-published_at').val(),
                            team_id: team_id,
                        }

                        if(formData.title == "" || formData.content == "")
                            flashMessage("La news n'a pas été publiée :\nvous devez remplir au moins le titre et le contenu de la news.");
                        else
                            NEWS.create(formData);
                    }
                }
            }
        });
        CKEDITOR.replace('create-news-content');

        var date = new Date(),
            d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();

        d = d < 10 ? '0'+d : d;
        m = m < 10 ? '0'+m : m;

        $('#create-news-published_at').val(d+'-'+m+'-'+y);
            
        $('#create-news-published_at').datepicker({dateFormat: "dd-mm-yy", minDate: new Date(y, m, d)});
    });


    $('#pictures .picture-block img').click(function()
    {
        var id = $(this).data()
    });

    </script>

    @yield('js')

</body>
</html>