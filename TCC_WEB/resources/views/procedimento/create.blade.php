@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">REGISTRAR PROCEDIMENTO</div>
                    {{ Form::open(['url' => 'procedimento', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    {{ Form::label('nome', 'NOME*', ['class'=>'control-label']) }}
                                    {{ Form::text('nome', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                    @if ($errors->has('nome'))
                                        <span class="help-block"><strong>{{ $errors->first('nome') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group{{ $errors->has('complexidade') ? ' has-error' : '' }}">
                                    {{ Form::label('complexidade', 'COMPLEXIDADE*', ['class'=>'control-label']) }}
                                    {{ Form::select('complexidade', $complexidades, null, ['class'=>'form-control', 'placeholder' => '']) }}
                                    @if ($errors->has('complexidade'))
                                        <span class="help-block"><strong>{{ $errors->first('complexidade') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('descricao', 'DESCRIÇÃO', ['class'=>'control-label']) }}
                                    {{ Form::textarea('descricao', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('procedimento') }}" class="btn btn-info pull-right">
                            VOLTAR
                        </a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection