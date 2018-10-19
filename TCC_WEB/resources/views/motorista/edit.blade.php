@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">EDITAR MOTORISTA #{{ $motorista->id }}</div>
                    {{ Form::model($motorista, ['route' => ['motorista.update', $motorista], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                            {{ Form::label('nome', 'NOME*', ['class'=>'control-label']) }}
                                            {{ Form::text('nome', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                            @if ($errors->has('nome'))
                                                <span class="help-block"><strong>{{ $errors->first('nome') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            {{ Form::label('email', 'EMAIL*', ['class'=>'control-label']) }}
                                            {{ Form::text('email', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('email'))
                                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                            {{ Form::label('telefone', 'TELEFONE*', ['class'=>'control-label']) }}
                                            {{ Form::text('telefone', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('telefone'))
                                                <span class="help-block"><strong>{{ $errors->first('telefone') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                                            {{ Form::label('celular', 'CELULAR', ['class'=>'control-label']) }}
                                            {{ Form::text('celular', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('celular'))
                                                <span class="help-block"><strong>{{ $errors->first('celular') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('admissao') ? ' has-error' : '' }}">
                                            {{ Form::label('admissao', 'ADMISSÃO*', ['class'=>'control-label']) }}
                                            {{ Form::date('admissao', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('admissao'))
                                                <span class="help-block"><strong>{{ $errors->first('admissao') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
                                            {{ Form::label('foto', 'FOTO', ['class'=>'control-label']) }}
                                            {{ Form::file('foto', ['class'=>'form-control']) }}
                                            @if ($errors->has('foto'))
                                                <span class="help-block"><strong>{{ $errors->first('foto') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group"><br/>
                                    <div class="img-responsive img-thumbnail" style="width: 100%; height: 195px">
                                        <img id="visualizar_img" src="{{ asset(!is_null($motorista->foto) ? 'upload/foto_motorista/'.$motorista->foto : 'sem_imagem.jpeg') }}" style="height: 100%; width: 100%" class="img-responsive img-thumbnail" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('motorista') }}" class="btn btn-info pull-right">
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