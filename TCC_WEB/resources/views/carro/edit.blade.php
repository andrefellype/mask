@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">EDITAR CARRO #{{ $carro->id }}</div>
                    {{ Form::model($carro, ['route' => ['carro.update', $carro], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
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
@section('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#visualizar_img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#foto").change(function () {
            readURL(this);
        });
        function getCep() {
            var cep = $("#cep").val();
            $.ajax({
                url: "http://viacep.com.br/ws/" + cep + "/json/",
                type: "GET",
                dataType: "JSON",
                beforeSend: inicializaPreloader()
            }).done(function (data) {
                    finalizaPreloader();
                    if(data.uf.length > 0)
                        $("#uf").val(data.uf);
                    if(data.localidade.length > 0)
                        $("#cidade").val(data.localidade);
                    if(data.bairro.length > 0)
                        $("#bairro").val(data.bairro);
                    if(data.logradouro.length > 0)
                        $("#logradouro").val(data.logradouro);
                }
            ).fail(function () {
                finalizaPreloader();
            });
        }
        function inicializaPreloader() {
            $(".prelaoder").show();
        }
        function finalizaPreloader() {
            $(".prelaoder").hide();
        }
    </script>
@endsection