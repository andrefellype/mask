@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">REGISTRAR AGENDAMENTO - VAGA #{{ $vaga->id }}</div>
                    {{ Form::open(['url' => 'agendamento/'.$vaga->id, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR")
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('paciente') ? ' has-error' : '' }}">
                                        {{ Form::label('paciente', 'PACIENTE*', ['class'=>'control-label']) }}
                                        {{ Form::select('paciente', $pacientes, null, ['class'=>'form-control', 'autofocus' => true, 'placeholder' => '']) }}
                                        @if ($errors->has('paciente'))
                                            <span class="help-block"><strong>{{ $errors->first('paciente') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('carro') ? ' has-error' : '' }}">
                                        {{ Form::label('carro', 'CARRO*', ['class'=>'control-label']) }}
                                        {{ Form::select('carro', $carros, null, ['class'=>'form-control', 'autofocus' => true, 'placeholder' => '']) }}
                                        @if ($errors->has('carro'))
                                            <span class="help-block"><strong>{{ $errors->first('carro') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('motorista') ? ' has-error' : '' }}">
                                        {{ Form::label('motorista', 'MOTORISTA*', ['class'=>'control-label']) }}
                                        {{ Form::select('motorista', $motoristas, null, ['class'=>'form-control', 'placeholder' => '']) }}
                                        @if ($errors->has('motorista'))
                                            <span class="help-block"><strong>{{ $errors->first('motorista') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('observacao', 'OBSERVAÇÃO', ['class'=>'control-label']) }}
                                    {{ Form::textarea('observacao', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('agendamento/'.$vaga->id) }}" class="btn btn-info pull-right">
                            VOLTAR
                        </a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection