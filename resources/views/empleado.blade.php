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
    Nombre del empleado: <?php echo "$nombre trabajo: $dias se le pago: $nomina"; ?>
    <br>
    Nombre del empleado: {{ $nombre }} trabajo: {{ $dias }} se le pago: {{ $nomina }}
</body>

</html>
