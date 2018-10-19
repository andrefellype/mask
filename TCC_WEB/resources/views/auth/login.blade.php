@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">ÁREA DE ACESSO</div>
                <div class="panel-body">
                    @include('layouts.flashMessages')
                    {{ Form::open(['route'=>'login', 'method'=>'POST', 'class'=>'form-horizontal']) }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', 'EMAIL*', ['class'=>'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email', null, ['class'=>'form-control', 'autofocus'=>true]) }}
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
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> LEMBRAR ME
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                ENTRAR
                            </button>
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                ESQUECEU SUA SENHA?
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
