<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('mensaje',[EmpleadosController::class,'mensaje']);
Route::get('controlpago',[EmpleadosController::class,'pago']);
Route::get('nomina/{diast}/{pago}',[EmpleadosController::class,'nomina']);


// enviar variables a nuestra vista
Route::get('muestrasaludo/{nombre}/{dias}',[EmpleadosController::class,'saludo']);
// le puese el nombre de salir para que lo detecte la vista
Route::get('salir',[EmpleadosController::class,'salir'])->name('salir');

Route::get('vb',[EmpleadosController::class,'vb'])->name('vb');
Route::get('vista1',[EmpleadosController::class,'vista1'])->name('vista1');
Route::get('vista2',[EmpleadosController::class,'vista2'])->name('vista2');

Route::get('altaempleado',[EmpleadosController::class,'altaempleado'])->name('altaempleado');
Route::post('guardarempleado',[EmpleadosController::class,'guardarempleado'])->name('guardarempleado');

Route::get('eloquent',[EmpleadosController::class,'eloquent'])->name('eloquent');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ruta1', function () {
    return "Hola OldSkool";
});
Route::get('/arearectangulo', function () {
    $base = 4;
    $altura = 10;
    $area = $base * $altura;
    return $area;
});
Route::get('/arearectangulo1', function () {
    $base = 4;
    $altura = 10;
    $area = $base * $altura;
    return "El area del rectangulo es: ".$area. " con base: $base y altura: $altura";
});
Route::get('/arearectangulo2/{base}/{altura}', function ($base,$altura) {

    $area = $base * $altura;
    return "El area del rectangulo es: ".$area. " con base: $base y altura: $altura";
});
                            // si pongo un signo de interrogacion quiere decir que no son obligatorias los valores, como ejemplo pagodiario?
/* Route::get('/nomina/{diast}/{pagodiario?}', function ($diast,$pagodiario=null) {
    if($pagodiario==null){

        $pagodiario = 100;
        $nomina = $diast * $pagodiario;
    } else {

        $nomina = $diast * $pagodiario;
    }
    echo "Dias Trabajados:  $diast ";
    echo "<br> Pago Nomina: " .  $pagodiario;
    echo "<br> Total Pago:  $nomina ";


}); */

// ruta de redireccionamiento
Route::get('/redireccionamiento', function () {
    return redirect('ruta1');
});

Route::redirect('redireccionamiento2','ruta1');
Route::redirect('redireccionamiento3','arearectangulo2/5/6');


Route::get('/redireccionamiento4/{base}/{altura}', function ($base,$altura) {


    return redirect("arearectangulo2/$base/$altura");
});

Route::redirect('redireccionamiento5','https://www.google.com');
