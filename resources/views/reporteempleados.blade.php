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
                        <td><button type="button" class="btn btn-info">Modificar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@stop
