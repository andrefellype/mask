@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">PACIENTES</div>
                    <div class="panel-footer">
                        <a href="{{ url('paciente/create') }}" class="btn btn-sm btn-success">REGISTRAR</a>
                    </div>
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px"></th>
                                <th width="50px">ID</th>
                                <th>NOME</th>
                                <th width="125px">NASCIMENTO</th>
                                <th width="125px">CPF</th>
                                <th width="125px">RG</th>
                                <th width="125px">TELEFONE</th>
                                <th width="150px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pacientes as $key => $value)
                                <tr>
                                    <td>
                                        <a href="{{ asset(!is_null($value->pessoa->foto) ? 'upload/foto_paciente/'.$value->pessoa->foto : 'sem_imagem.jpeg') }}" target="_blank">
                                            <img id="visualizar_img" src="{{ asset(!is_null($value->pessoa->foto) ? 'upload/foto_paciente/'.$value->pessoa->foto : 'sem_imagem.jpeg') }}" style="height: 30px; width: 50px" class="img-responsive" />
                                        </a>
                                    </td>
                                    <th>{{ $value->id }}</th>
                                    <td>{{ $value->pessoa->nome }}</td>
                                    <td>{{ date("d/m/Y", strtotime($value->nascimento)) }}</td>
                                    <td>{{ $value->cpf }}</td>
                                    <td>{{ $value->rg }}</td>
                                    <td>{{ $value->telefone->telefone }}</td>
                                    <td align="center">
                                        {{ Form::open(array('url' => 'paciente/' . $value->id, 'onsubmit' => 'return confirm("TEM CERTEZA QUE DESEJA APAGAR?")')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <a href="{{ url('paciente/'.$value->id.'/edit') }}" class="btn btn-info btn-xs">EDITAR</a>
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
