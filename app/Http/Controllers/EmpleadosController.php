<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    //
    public function saludo($nombre,$dias){

      return view('empleado',compact('nombre','dias'));
    }
    public function mensaje(){

      return "Hola trabajador";
    }

    public function pago(){

        $dias = 7;
        $pago = 600;
        $nomina = $dias * $pago;
        return "el pago del empleado es: $nomina";
    }

    public function nomina($diast,$pago){
        $nomina = $diast * $pago;
        // manda el valor de la variable como un depurador
        dd($nomina,$diast,$pago );
        return "el pago es $nomina con dias $diast y el pago diario de $pago";
    }
}
