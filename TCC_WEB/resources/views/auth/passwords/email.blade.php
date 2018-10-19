@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">RECUPERAR SENHA</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <b>{{ session('status') }}</b>
                        </div>
                    @endif
                    @include('layouts.flashMessages')
                    {{ Form::open(['route'=>'password.email', 'method'=>'POST', 'class'=>'form-horizontal']) }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', 'EMAIL*', ['class'=>'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                ENVIAR SENHA
                            </button>
                            <a class="btn btn-link" href="{{ route('login') }}">
                                ÁREA DE ACESSO
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
