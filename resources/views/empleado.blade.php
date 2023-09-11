<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <h1>Empresa PATITO.com</h1>

    <br>
    Nombre del empleado: {{ $nombre }} trabajo: {{ $dias }} se le pago: {{ $nomina }}
    <br>
    @if ($nombre == 'apple')
        <h1>Hola Apple</h1>
        <br>
        {{-- para acceder a la carpeta public fotos hay que acceder con la funcion asset y emtre comillas la ruta --}}
        <img src="{{ asset('fotos/apple.png') }}" weight=200 height=200>
    @endif
    @if ($nombre = 'star')
        <h1>Hola StarBucks</h1>
        <br>
        {{-- para acceder a la carpeta public fotos hay que acceder con la funcion asset y emtre comillas la ruta --}}
        <img src="{{ asset('fotos/star.png') }}" weight=200 height=200>
    @else
        <h1>Sin foto</h1>
    @endif
    {{-- para utilizar la funcion route, hay que renombrar el nombre de la ruta --}}
    <a href="{{ route('salir') }}">Cerrar Nomina</a>
</body>

</html>
