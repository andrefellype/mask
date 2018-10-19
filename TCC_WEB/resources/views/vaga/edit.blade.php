@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">REGISTRAR VAGA #{{ $vaga->id }}</div>
                    {{ Form::model($vaga, ['route' => ['vaga.update', $vaga], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('data') ? ' has-error' : '' }}">
                                    {{ Form::label('data', 'DATA*', ['class'=>'control-label']) }}
                                    {{ Form::date('data', date("Y-m-d"), ['class'=>'form-control', 'autofocus'=>true]) }}
                                    @if ($errors->has('data'))
                                        <span class="help-block"><strong>{{ $errors->first('data') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('hora') ? ' has-error' : '' }}">
                                    {{ Form::label('hora', 'HORA*', ['class'=>'control-label']) }}
                                    {{ Form::time('hora', null, ['class'=>'form-control']) }}
                                    @if ($errors->has('hora'))
                                        <span class="help-block"><strong>{{ $errors->first('hora') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('quantidade') ? ' has-error' : '' }}">
                                    {{ Form::label('quantidade', 'QUANTIDADE*', ['class'=>'control-label']) }}
                                    {{ Form::text('quantidade', null, ['class'=>'form-control']) }}
                                    @if ($errors->has('quantidade'))
                                        <span class="help-block"><strong>{{ $errors->first('quantidade') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('procedimento') ? ' has-error' : '' }}">
                                    {{ Form::label('procedimento', 'PROCEDIMENTO*', ['class'=>'control-label']) }}
                                    {{ Form::select('procedimento', $procedimentos, null, ['class'=>'form-control', 'placeholder' => '']) }}
                                    @if ($errors->has('procedimento'))
                                        <span class="help-block"><strong>{{ $errors->first('procedimento') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('vaga') }}" class="btn btn-info pull-right">
                            VOLTAR
                        </a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection