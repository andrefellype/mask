@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">PROCEDIMENTOS</div>
                    @if(Session::has('prestador'))
                        <div class="panel-footer">
                            <a href="{{ url('procedimento/create') }}" class="btn btn-sm btn-success">REGISTRAR</a>
                        </div>
                    @endif
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>NOME</th>
                                <th width="150px">COMPLEXIDADE</th>
                                @if(!Session::has('prestador'))
                                    <th width="200px">PRESTADOR</th>
                                @endif
                                <th>DESCRIÇÃO</th>
                                @if(Session::has('prestador'))
                                    <th width="150px"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($procedimentos as $key => $value)
                                <tr>
                                    <th>{{ $value->id }}</th>
                                    <th>{{ $value->nome }}</th>
                                    <th>{{ $value->complexidade == 0 ? "BAIXA" : ($value->complexidade == 1 ? "MÉDIA" : "ALTA") }}</th>
                                    @if(!Session::has('prestador'))
                                        <th>{{ $value->nome_prestador }}</th>
                                    @endif
                                    <th>{{ $value->descricao }}</th>
                                    @if(Session::has('prestador'))
                                        <td align="center">
                                            {{ Form::open(array('url' => 'procedimento/' . $value->id, 'onsubmit' => 'return confirm("TEM CERTEZA QUE DESEJA APAGAR?")')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <a href="{{ url('procedimento/'.$value->id.'/edit') }}" class="btn btn-info btn-xs">EDITAR</a>
                                            <button class="btn btn-xs btn-danger" type="submit">APAGAR</button>
                                            {{ Form::close() }}
                                        </td>
                                    @endif
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
