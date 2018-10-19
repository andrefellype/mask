@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">REGISTRAR ADMINISTRADOR</div>
                    {{ Form::open(['url' => 'administrador', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'NOME*', ['class'=>'control-label']) }}
                            {{ Form::text('name', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', 'EMAIL*', ['class'=>'control-label']) }}
                            {{ Form::text('email', null, ['class'=>'form-control']) }}
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    {{ Form::label('password', 'SENHA*', ['class'=>'control-label']) }}
                                    {{ Form::password('password', ['class'=>'form-control']) }}
                                    @if ($errors->has('password'))
                                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    {{ Form::label('password-confirm', 'CONFIRMAR SENHA', ['class'=>'control-label']) }}
                                    {{ Form::password('password_confirmation', ['id'=>'password-confirm', 'class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('administrador') }}" class="btn btn-info pull-right">
                            VOLTAR
                        </a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection