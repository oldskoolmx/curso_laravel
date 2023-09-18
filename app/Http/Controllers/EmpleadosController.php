<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\empleados;
use App\Models\departamentos;

class EmpleadosController extends Controller
{
    //

    public function eloquent(){
        // realizamos una consulta para ver la conexion a la BD
        // es como si ejecutara un select
        //$consulta = empleados::all();

        // un nuevo registro sobre el modelo empleados
       /*  $empleados = new empleados;
        $empleados->ide=6;
        $empleados->nombre="gustavo1";
        $empleados->apellido="barrios1";
        $empleados->email="merolmen1@gmail.com";
        $empleados->celular="5522935971";
        $empleados->sexo="M";
        $empleados->descripcion="Prueba de insercion";
        $empleados->idd=1;
        $empleados->save(); */

        //otro ejemplo de insertar registros, podemos hacer insercion masiva
      /*  $empleados = empleados::create([
            'ide'=>4,'nombre'=>"Paty",'apellido'=>"Mendez",'email'=>"paty@gmail.com",
            'celular'=>"5582226400",'sexo'=>"F",'descripcion'=>"prueba",'edad'=> 28,'salario'=>55000,'idd'=>1
        ]);

        return "Operacion Realizada"; */




        // para actualizar un registro en especifico, este caso el registro con id 6
       /*  $empleados = empleados::find(6);
        $empleados->nombre = "Dulce";
        $empleados->apellido = "Montiel";
        $empleados->save(); */

        //otro metodo para modificar con una condicion
       /*  empleados::where('sexo','M')
        ->where('email','merolmen@gmail.com')
        ->update(['nombre'=>'francisco','celular'=>'5555555555']);

        return "Modificaion Realizada"; */

        // eliminacion de un registro

        //empleados::destroy(4);

        //otra forma de eliminar un registro

        /* $empleados = empleados::find(8);
        $empleados->delete();
        return "Eliminacion Realizada"; */
        //otra forma de eliminar con una condicion

       /*  $empleados=empleados::where('sexo','F')
        ->where('celular','5582226400')
        ->delete(); */

        /* $empleados = empleados::find(6);
        $empleados->delete();
        return "Eliminacion Realizada"; */

       /*  $consulta = empleados::all();
        return $consulta; */

        //para que me muestre todos los registros incluyendo los borrados logicos
       /*  $consulta = empleados::withTrashed()->get();
        return $consulta; */

        // para ver unicamente los registros borrados logicos
        //$consulta = empleados::onlyTrashed()->get();

        //consulta de los eliminados logicos con una condicion
       /*  $consulta = empleados::onlyTrashed()
        ->where('sexo','M')
        ->get(); */


        // para restaurar un resgistro borrado logicamente
        // empleados::withTrashed()->where('ide',6)->restore();
        // return "Restauracion Realizada";

        //para borrar un registro permanentemente
       // $consulta = empleados::find(6)->forceDelete();
        //$consulta = empleados::all();
        //$consulta = empleados::where('sexo','M')->get();
        // una consulta entre rangos de edad
        /* $consulta = empleados::where('edad','>=',20)
        ->where('edad','<=',25)
        ->get(); */

        // consulta para rangos
        $consulta = empleados::whereBetween('edad',[20,30])->get();
        
        // consulta solo de esos tres ide
        $consulta = empleados::whereIn('ide',[13,14,15])
            ->orderBy('nombre','desc')
            ->get();

        $consulta = empleados::where('edad','>=',20)
            ->where('edad','<=',30)
            // con take solo toma los 2 primeros registros de la consulta
            ->take(2)
            ->get();    
        
        return $consulta;

    }

    public function altaempleado(){

        return view('altaempleado');
    }

    // hay que poner Request para mandar los datos a las variables
    public function guardarempleado(Request $request){

        //return view('altaempleado');
        // se envia en forma de arreglo toda la info
        //return $request;
        // enviar de otra forma la informacion como tipo debug
        //dd($request);
                   // este es el nombre del input
        $nombre = $request->nombre;
        $sexo = $request->sexo;
        // para hacer validaciones, reglas de validacion
        $this->validate($request,[
            // con esta regla se pueden agregar cualquier letra de la A a la Z
            // 'ide' => 'required|regex:/^[A-Z]{3}[-][0-9]{5}$/',
            'ide' => 'required|regex:/^[E][M][P][-][0-9]{5}$/',
            'nombre' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            // si le pongo asterisco en lugar del mas, es para indicar que lleva un numero o no antes del
            //punto decimal
            //'apellido' => 'required|regex:/^[0-9]+[.][0-9]{2}$/',
            'apellido' => 'required|regex:/^[0-9]*[.][0-9]{2}$/',
            'email' => 'required|email',
            'celular' => 'required|regex:/^[0-9]{10}$/'
        ]);

       echo "TODO CORRECTO";
    }
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
