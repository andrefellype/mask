@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">AGENDAMENTOS DA VAGA #{{ $vaga->id }}</div>
                    <div class="panel-footer">
                        <a href="{{ url('agendamento/create/'.$vaga->id) }}" class="btn btn-sm btn-success">REGISTRAR</a>
                        <a href="{{ url('vaga') }}" class="btn btn-sm btn-info">VOLTAR</a>
                    </div>
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th width="200px">DATA DA SOLICITAÇÃO</th>
                                <th>{{ Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR" ? "PACIENTE" : "MOTORISTA" }}</th>
                                @if(Auth::user()->nivel == "GESTOR MOTORISTA")
                                    <th>CARRO</th>
                                @endif
                                @if($observacao)
                                    <th>OBSERVAÇÃO</th>
                                @endif
                                @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR")
                                    <th width="200px">STATUS</th>
                                @endif
                                <th width="50px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($agendamentos as $key => $value)
                                <tr class="{{ $value->status_num != -1 ? "text-info" : "text-danger" }}">
                                    <th>{{ $value->id }}</th>
                                    <th>{{ date("d/m/Y H:i:s", strtotime($value->data)) }}</th>
                                    <th>{{ Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR" ? $value->paciente->pessoa->nome : $value->motorista->pessoa->nome }}</th>
                                    @if(Auth::user()->nivel == "GESTOR MOTORISTA")
                                        <th>{{ $value->carro->modelo . " - PLACA:" . $value->carro->placa }}</th>
                                    @endif
                                    @if($observacao)
                                        <th>{{ $value->observacao }}</th>
                                    @endif
                                    @if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR")
                                        <th>{{ $value->status }}</th>
                                    @endif
                                    <td align="center">
                                        {{ Form::open(array('url' => 'agendamento/'.$value->id, 'onsubmit' => 'return confirm("TEM CERTEZA QUE DESEJA APAGAR?")')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <button class="btn btn-xs btn-danger" type="submit">APAGAR</button>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
