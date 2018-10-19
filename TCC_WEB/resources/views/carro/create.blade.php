@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">REGISTRAR CARRO</div>
                    {{ Form::open(['url' => 'carro', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('modelo') ? ' has-error' : '' }}">
                                    {{ Form::label('modelo', 'MODELO*', ['class'=>'control-label']) }}
                                    {{ Form::text('modelo', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                    @if ($errors->has('modelo'))
                                        <span class="help-block"><strong>{{ $errors->first('modelo') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('placa') ? ' has-error' : '' }}">
                                    {{ Form::label('placa', 'PLACA*', ['class'=>'control-label']) }}
                                    {{ Form::text('placa', null, ['class'=>'form-control']) }}
                                    @if ($errors->has('placa'))
                                        <span class="help-block"><strong>{{ $errors->first('placa') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('cor') ? ' has-error' : '' }}">
                                    {{ Form::label('cor', 'COR*', ['class'=>'control-label']) }}
                                    {{ Form::color('cor', null, ['class'=>'form-control']) }}
                                    @if ($errors->has('cor'))
                                        <span class="help-block"><strong>{{ $errors->first('cor') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('limite_pessoas') ? ' has-error' : '' }}">
                                    {{ Form::label('limite_pessoas', 'LIMITE DE PESSOAS*', ['class'=>'control-label']) }}
                                    {{ Form::text('limite_pessoas', null, ['class'=>'form-control']) }}
                                    @if ($errors->has('limite_pessoas'))
                                        <span class="help-block"><strong>{{ $errors->first('limite_pessoas') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('carro') }}" class="btn btn-info pull-right">
                            VOLTAR
                        </a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection