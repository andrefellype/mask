@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">DADOS DO ADMINISTRADOR #{{ $administrador->id }}</div>
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="form-group">
                            {{ Form::label('', 'NOME', ['class'=>'control-label']) }}
                            {{ Form::text('', $administrador->name, ['class'=>'form-control', 'disabled'=>true]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('', 'EMAIL', ['class'=>'control-label']) }}
                            {{ Form::text('', $administrador->email, ['class'=>'form-control', 'disabled'=>true]) }}
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ url('administrador') }}" class="btn btn-info">
                            VOLTAR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection