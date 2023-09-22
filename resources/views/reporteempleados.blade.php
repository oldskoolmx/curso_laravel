@extends('vistaboostrap')

@section('contenido')

    <div class="container">
        <h1>REPORTE DE EMPLEADOS</h1>
        <br>
        <a href="{{ route('altaempleado') }}">

            <button type="button" class="btn btn-success">Alta de Empleado</button>
        </a>

        <br>
        <br>
        @if (Session::has('mensaje'))
            <div class="alert alert-success">{{ Session::get('mensaje') }}</div>
        @endif
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Clave</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Area</th>
                    <th scope="col">Operaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consulta as $c)
                    <tr>
                        <th scope="row">{{ $c->ide }}</th>
                        <td>{{ $c->nombre }} {{ $c->apellido }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->depa }}</td>
                        <td>
                            <a href="{{ route('modificaempleado', ['ide' => $c->ide]) }}">
                                <button type="button" class="btn btn-info">Modificar</button>
                            </a>
                            {{-- creamos una condicion para activar los registros borrados logicamente  anteriormente --}}
                            @if ($c->deleted_at)
                                <a href="{{ route('activarempleado', ['ide' => $c->ide]) }}">
                                    <button type="button" class="btn btn-warning">Activar</button>
                                </a>
                                <a href="{{ route('borrarempleado', ['ide' => $c->ide]) }}">
                                    <button type="button" class="btn btn-secondary">Borrar</button>
                                </a>
                            @else
                                <a href="{{ route('desactivaempleado', ['ide' => $c->ide]) }}">
                                    <button type="button" class="btn btn-danger">Desactivar</button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@stop
