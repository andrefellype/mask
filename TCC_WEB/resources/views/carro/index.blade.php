@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">CARROS</div>
                    <div class="panel-footer">
                        <a href="{{ url('carro/create') }}" class="btn btn-sm btn-success">REGISTRAR</a>
                    </div>
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>MODELO</th>
                                <th width="200px">PLACA</th>
                                <th width="200px">COR</th>
                                <th width="100px">PESSOAS</th>
                                <th width="150px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($carros as $key => $value)
                                <tr>
                                    <th>{{ $value->id }}</th>
                                    <th>{{ $value->modelo }}</th>
                                    <th>{{ $value->placa }}</th>
                                    <th style="background-color: {{ $value->cor }}; font-weight: bold;">{{ $value->cor }}</th>
                                    <td>{{ $value->limite_pessoas }}</td>
                                    <td align="center">
                                        {{ Form::open(array('url' => 'carro/' . $value->id, 'onsubmit' => 'return confirm("TEM CERTEZA QUE DESEJA APAGAR?")')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <a href="{{ url('carro/'.$value->id.'/edit') }}" class="btn btn-info btn-xs">EDITAR</a>
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
