<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .panel-heading{
            font-weight: bold;
            text-transform: uppercase;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                @if(Auth::check())
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('home') }}">INÍCIO</a></li>
                        @if(Auth::user()->nivel == "ADMINISTRADOR" || Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR" || Auth::user()->nivel == "GESTOR MOTORISTA")
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre> USUÁRIOS <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(Auth::user()->nivel == "ADMINISTRADOR")
                                        <li><a href="{{ url('administrador') }}">ADMINISTRADOR</a></li>
                                        <li><a href="{{ url('gestor') }}">GESTOR</a></li>
                                    @endif
                                    @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR")
                                        <li><a href="{{ url('paciente') }}">PACIENTE</a></li>
                                    @endif
                                    @if(Auth::user()->nivel == "GESTOR MOTORISTA")
                                        <li><a href="{{ url('motorista') }}">MOTORISTA</a></li>
                                    @endif
                                    @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR")
                                        <li><a href="{{ url('prestador') }}">PRESTADOR</a></li>
                                    @endif
                                </ul>
                            </li>
                            @if(Auth::user()->nivel == "GESTOR MOTORISTA")
                                <li><a href="{{ url('carro') }}">CARRO</a></li>
                            @endif
                        @endif
                        @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR" || Session::has('prestador'))
                            <li><a href="{{ url('procedimento') }}">PROCEDIMENTO</a></li>
                        @endif
                        @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR" || Auth::user()->nivel == "GESTOR MOTORISTA" || Session::has('prestador'))
                            <li><a href="{{ url('vaga') }}">VAGA</a></li>
                        @endif
                    </ul>
                @endif
                <ul class="nav navbar-nav navbar-right">
                    @if(\App\User::count() > 0)
                        @if(Auth::check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(Session::has('prestador'))
                                        <li><a href="{{ url('prestador/'.Session::get('prestador')->id) }}">PRESTADOR</a></li>
                                    @endif
                                    <li><a href="{{ url('usuario/'.Auth::id().'/edit') }}">USUÁRIO</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            SAIR
                                        </a>
                                        {{ Form::open(['route'=>'logout', 'method'=>'POST', 'id'=>'logout-form', 'style'=>'display: none']) }}{{ Form::close() }}
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">LOGIN</a></li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</div>
@yield('script')
</body>
</html>