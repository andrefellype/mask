@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">EDITAR PROCEDIMENTO #{{ $procedimento->id }}</div>
                    {{ Form::model($procedimento, ['route' => ['procedimento.update', $procedimento], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
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