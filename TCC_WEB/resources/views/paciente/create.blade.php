@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">REGISTRAR PACIENTE</div>
                    {{ Form::open(['url' => 'paciente', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                            {{ Form::label('nome', 'NOME*', ['class'=>'control-label']) }}
                                            {{ Form::text('nome', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                            @if ($errors->has('nome'))
                                                <span class="help-block"><strong>{{ $errors->first('nome') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            {{ Form::label('email', 'EMAIL*', ['class'=>'control-label']) }}
                                            {{ Form::text('email', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('email'))
                                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                            {{ Form::label('telefone', 'TELEFONE*', ['class'=>'control-label']) }}
                                            {{ Form::text('telefone', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('telefone'))
                                                <span class="help-block"><strong>{{ $errors->first('telefone') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                                            {{ Form::label('celular', 'CELULAR', ['class'=>'control-label']) }}
                                            {{ Form::text('celular', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('celular'))
                                                <span class="help-block"><strong>{{ $errors->first('celular') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('nascimento') ? ' has-error' : '' }}">
                                            {{ Form::label('nascimento', 'NASCIMENTO*', ['class'=>'control-label']) }}
                                            {{ Form::date('nascimento', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('nascimento'))
                                                <span class="help-block"><strong>{{ $errors->first('nascimento') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                            {{ Form::label('cpf', 'CPF*', ['class'=>'control-label']) }}
                                            {{ Form::text('cpf', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('nascimento'))
                                                <span class="help-block"><strong>{{ $errors->first('nascimento') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
                                            {{ Form::label('rg', 'RG*', ['class'=>'control-label']) }}
                                            {{ Form::text('rg', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('rg'))
                                                <span class="help-block"><strong>{{ $errors->first('rg') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                            {{ Form::label('cep', 'CEP*', ['class'=>'control-label']) }}
                                            {{ Form::text('cep', null, ['class'=>'form-control', 'onchange' => 'getCep()']) }}
                                            @if ($errors->has('cep'))
                                                <span class="help-block"><strong>{{ $errors->first('cep') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                                            {{ Form::label('numero', 'NÚMERO*', ['class'=>'control-label']) }}
                                            {{ Form::text('numero', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('numero'))
                                                <span class="help-block"><strong>{{ $errors->first('numero') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{ $errors->has('complemento') ? ' has-error' : '' }}">
                                            {{ Form::label('complemento', 'COMPLEMENTO', ['class'=>'control-label']) }}
                                            {{ Form::text('complemento', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('complemento'))
                                                <span class="help-block"><strong>{{ $errors->first('complemento') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('logradouro') ? ' has-error' : '' }}">
                                            {{ Form::label('logradouro', 'LOGRADOURO*', ['class'=>'control-label']) }}
                                            {{ Form::text('logradouro', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('logradouro'))
                                                <span class="help-block"><strong>{{ $errors->first('logradouro') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
                                            {{ Form::label('bairro', 'BAIRRO*', ['class'=>'control-label']) }}
                                            {{ Form::text('bairro', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('bairro'))
                                                <span class="help-block"><strong>{{ $errors->first('bairro') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
                                            {{ Form::label('cidade', 'CIDADE*', ['class'=>'control-label']) }}
                                            {{ Form::text('cidade', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('cidade'))
                                                <span class="help-block"><strong>{{ $errors->first('cidade') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group{{ $errors->has('uf') ? ' has-error' : '' }}">
                                            {{ Form::label('uf', 'UF*', ['class'=>'control-label']) }}
                                            {{ Form::text('uf', null, ['class'=>'form-control']) }}
                                            @if ($errors->has('uf'))
                                                <span class="help-block"><strong>{{ $errors->first('uf') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
                                    {{ Form::label('foto', 'FOTO', ['class'=>'control-label']) }}
                                    {{ Form::file('foto', ['class'=>'form-control']) }}
                                    @if ($errors->has('foto'))
                                        <span class="help-block"><strong>{{ $errors->first('foto') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="img-responsive img-thumbnail" style="width: 100%; height: 143px">
                                        <img id="visualizar_img" src="{{ asset('sem_imagem.jpeg') }}" style="height: 100%; width: 100%" class="img-responsive img-thumbnail" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                        </button>
                        <a href="{{ url('paciente') }}" class="btn btn-info pull-right">
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