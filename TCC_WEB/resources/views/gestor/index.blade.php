@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">GESTORES</div>
                    <div class="panel-footer">
                        <a href="{{ url('gestor/create') }}" class="btn btn-sm btn-success">REGISTRAR</a>
                    </div>
                    <div class="panel-body">
                        @include('layouts.flashMessages')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>NOME</th>
                                <th>EMAIL</th>
                                <th width="175px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gestores as $key => $value)
                                <tr>
                                    <th>{{ $value->id }}</th>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td align="center">
                                        {{ Form::open(array('url' => 'gestor/' . $value->id, 'onsubmit' => 'return confirm("TEM CERTEZA QUE DESEJA APAGAR?")')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <a href="{{ url('gestor/'.$value->id) }}" class="btn btn-info btn-xs">VISUALIZAR</a>
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
