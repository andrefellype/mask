@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DADOS DO PRESTADOR #{{ $prestador->id }}</div>
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', 'NOME', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->nome, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', 'EMAIL', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->email, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', 'TELEFONE', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->telefone, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', 'CEP', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->cep, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{ Form::label('', 'NÚMERO', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->numero, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('', 'COMPLEMENTO', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->complemento, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', 'LOGRADOURO', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->logradouro, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('', 'BAIRRO', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->bairro, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', 'CIDADE', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->cidade, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{ Form::label('', 'UF', ['class'=>'control-label']) }}
                                            {{ Form::text('', $prestador->uf, ['class'=>'form-control', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><br/>
                                    <div class="img-responsive img-thumbnail" style="width: 100%; height: 195px">
                                        <a href="{{ asset(!is_null($prestador->foto) ? 'upload/foto_prestador/'.$prestador->foto : 'sem_imagem.jpeg') }}" target="_blank">
                                            <img id="visualizar_img" src="{{ asset(!is_null($prestador->foto) ? 'upload/foto_prestador/'.$prestador->foto : 'sem_imagem.jpeg') }}" style="height: 100%; width: 100%" class="img-responsive img-thumbnail" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection