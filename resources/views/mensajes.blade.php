@extends('vistaboostrap')

@section('contenido')

    <div class="container">
        <h1>PROCESO {{ $proceso }}</h1>
        <br>
        @if ($error == 1)
            <div class="alert alert-success">{{ $mensaje }}</div>
        @else
            <div class="alert alert-warning">{{ $mensaje }}</div>
        @endif
    </div>

@stop
