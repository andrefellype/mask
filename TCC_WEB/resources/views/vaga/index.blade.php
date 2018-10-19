@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">VAGA</div>
                    @if(Session::has('prestador'))
                        <div class="panel-footer">
                            <a href="{{ url('vaga/create') }}" class="btn btn-sm btn-success">REGISTRAR</a>
                        </div>
                    @endif
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>PROCEDIMENTO</th>
                                <th width="200px">DATA</th>
                                <th width="150px">QUANTIDADE</th>
                                @if(!Session::has('prestador'))
                                    <th width="100px">AGENDADO</th>
                                @endif
                                @if(Session::has('prestador'))
                                    <th width="150px"></th>
                                @else
                                    <th width="100px"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vagas as $key => $value)
                                <tr>
                                    <th>{{ $value->id }}</th>
                                    <th>{{ $value->procedimento->nome . " - PRESTADOR: " . $value->procedimento->prestador_nome }}</th>
                                    <th>{{ date("d/m/Y H:i:s", strtotime($value->data)) }}</th>
                                    <th>{{ $value->quantidade }}</th>
                                    @if(!Session::has('prestador'))
                                        <th>{{ $value->agendada }}</th>
                                    @endif
                                    <td align="center">
                                        @if(Session::has('prestador'))
                                            {{ Form::open(array('url' => 'vaga/' . $value->id, 'onsubmit' => 'return confirm("TEM CERTEZA QUE DESEJA APAGAR?")')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <a href="{{ url('vaga/'.$value->id.'/edit') }}" class="btn btn-info btn-xs">EDITAR</a>
                                            <button class="btn btn-xs btn-danger" type="submit">APAGAR</button>
                                            {{ Form::close() }}
                                        @else
                                            <a href="{{ url('agendamento/'.$value->id) }}" class="btn btn-info btn-xs">AGENDAMENTO</a>
                                        @endif
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
