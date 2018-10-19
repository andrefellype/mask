@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Administrador</div>
                <div class="panel-body">
                    @include('layouts.flashMessages')
                    {{ Form::open(['route'=>'register', 'method'=>'POST', 'class'=>'form-horizontal']) }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', 'NOME*', ['class'=>'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('name', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', 'EMAIL*', ['class'=>'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email', null, ['class'=>'form-control']) }}
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        {{ Form::label('password', 'SENHA*', ['class'=>'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password('password', ['class'=>'form-control']) }}
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        {{ Form::label('password-confirm', 'CONFIRMAR SENHA', ['class'=>'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password('password_confirmation', ['id'=>'password-confirm', 'class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                REGISTRAR
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
