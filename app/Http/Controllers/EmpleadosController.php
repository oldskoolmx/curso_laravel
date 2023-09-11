<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    //

    public function vb(){

        return view('vistaboostrap');
    }
    public function vista1(){

        return view('vista1');
    }
    public function vista2(){

        return view('vista2');
    }

    public function saludo($nombre,$dias){

        $pago = 100;
        $nomina = $dias * $pago;


            // tres formas de mandar variables

      //return view('empleado',compact('nombre','dias'));
      //return view('empleado',['nombrex' =>$nombre,'dias'=>$dias]);
      // otra manera de enviar variables a una vista
      return view('empleado')
      ->with('nombre',$nombre)
      ->with('dias',$dias)
      ->with('nomina',$nomina);
    }

    public function salir(){

        return "Salir";
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
