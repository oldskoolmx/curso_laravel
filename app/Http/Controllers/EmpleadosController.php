<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\empleados;
use App\Models\departamentos;
use App\Models\nominas;
use Session;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    //

        // mandamos el $ide a desactivar o borrar
    public function modificaempleado($ide){


        $consulta = empleados::withTrashed()->join('departamentos','empleados.idd','=','departamentos.idd')
        ->select('empleados.ide','empleados.nombre','empleados.apellido','departamentos.nombre as depa',
        'empleados.email','empleados.idd','empleados.descripcion','empleados.celular','empleados.sexo','empleados.img')
       ->where('ide',$ide)
         ->get();
         $departamentos = departamentos::all();
        return view('modificaempleado')
        //se le pone forzosamente [0] para que solo regrese un registro
        ->with('consulta',$consulta[0])
        // mandamos tambien con la vista todos los departamentos para el select
        ->with('departamentos',$departamentos);


    }
    public function guardacambios(Request $request){

        $this->validate($request,[

            'nombre' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'apellido' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'email' => 'required|email',
            'celular' => 'required|regex:/^[0-9]{10}$/',
            'img' => 'image|mimes:gif,jpg,png'
        ]);

        $file = $request->file('img');
        // creamos la validacion por si el usuario no ingresa una foto, en automatico el sistema registre la foto llamada sinfoto.png
        if($file<>"") {
        // esta instruccion es para obtener la ruta original del archivo
        $img = $file->getClientOriginalName();
        // si dos usuarios suben la misma imagen con el mismo nombre hacemos esto para evitar que se reemplacen
        $img2 = $request->ide . $img;
        \Storage::disk('local')->put($img2,\File::get($file));
        }

        $empleados = empleados::withTrashed()->find($request->ide);
        $empleados->ide=$request->ide;
        $empleados->nombre=$request->nombre;
        $empleados->apellido=$request->apellido;
        $empleados->email=$request->email;
        $empleados->celular=$request->celular;
        $empleados->sexo=$request->sexo;
        $empleados->descripcion=$request->descripcion;
        // si el usuario no selecciona una foto, que no actualice el nombre
        if($file<>"") {
            $empleados->img = $img2;
        }
        $empleados->idd=$request->idd;
        $empleados->save();

        /* return view('mensajes')
        ->with('proceso',"MODIFICA EMPLEADOS")
        ->with('mensaje',"El empleado $request->ide $request->nombre $request->apellido ha sido dado modificado correctamente")
        ->with('error',1); */
        Session::flash('mensaje',"El empleado $request->ide $request->nombre $request->apellido ha sido dado modificado correctamente");
        return  redirect()->route('reporteempleados');

    }

    public function desactivaempleado($ide){

        $empleados = empleados::find($ide);
        $empleados->delete();
       /*  return view('mensajes')
        ->with('proceso',"DESACTIVAR EMPLEADO")
        ->with('mensaje',"El empleado ha sido desactivado correctamente")
        ->with('error',1); */

        Session::flash('mensaje',"El empleado ha sido desactivado correctamente");
        return  redirect()->route('reporteempleados');


    }
    public function activarempleado($ide){

        $empleados = empleados::withTrashed()->where('ide',$ide)->restore();
       /*  return view('mensajes')
        ->with('proceso',"ACTIVAR EMPLEADO")
        ->with('mensaje',"El empleado ha sido activado correctamente")
        ->with('error',1);
 */

        Session::flash('mensaje',"El empleado ha sido activado correctamente");
            return  redirect()->route('reporteempleados');


    }
    public function borrarempleado($ide){

        //para hacer una consulta a la tabla de nominas
        $buscarempleado=nominas::where('ide',$ide)->get();
        $cuantos = count($buscarempleado);
        // si no encuentra empleados en la tabla nomimas que los borre
        if ($cuantos==0) {
            # code...

            // que busque el registro que esta eliminado logicamente para borrarlo definitivamente
            $empleados = empleados::withTrashed()->find($ide)->forceDelete();
           /*  return view('mensajes')
            ->with('proceso',"BORRAR EMPLEADO")
            ->with('mensaje',"El empleado ha sido borrado del sistema correctamente")
            // mandamos una variable llamada error con un 1 para cambiar el color del texto
            ->with('error',1); */

            Session::flash('mensaje',"El empleado sido dado borrado del sistema correctamente");
            return  redirect()->route('reporteempleados');


        } else {
            /* return view('mensajes')
            ->with('proceso',"BORRAR EMPLEADO")
            ->with('mensaje',"El empleado no se puede borrar, ya que tiene registros de nomina")
            ->with('error',0); */

            Session::flash('mensaje',"El empleado no se puede borrar del sistema, por que tiene registros de nomina");
            return  redirect()->route('reporteempleados');
            # code...
        }


    }
    public function reporteempleados(){

      // devuelve todos los registros menos los eliminados logicamente
        /*  $consulta = empleados::join('departamentos','empleados.idd','=','departamentos.idd')
                ->select('empleados.ide','empleados.nombre','empleados.apellido','departamentos.nombre as depa',
                'empleados.email')
                ->orderBy('empleados.nombre')
                 ->get(); */


        $consulta = empleados::withTrashed()->join('departamentos','empleados.idd','=','departamentos.idd')
                ->select('empleados.ide','empleados.nombre','empleados.apellido','departamentos.nombre as depa',
                'empleados.email','empleados.deleted_at','empleados.img')
                ->orderBy('empleados.nombre')
                 ->get();
        return view('reporteempleados')->with('consulta',$consulta);
    }

    public function altaempleado(){

        // consulta para saber cual es el ultimo id en la tabla
        $consulta = empleados::orderBy('ide','desc')
                                ->take(1)->get();

               // consulta para sumarle una posicion al ultimo id en la base de datos
        $cuantos = count($consulta);
        if ($cuantos == 0) {
            # code...
            $idesigue=1;
        } else {

            $idesigue = $consulta[0]->ide + 1;
        }

        // consulta para sacar todos los departamentos de la bd
        $departamentos = departamentos::all();
        $departamentos = departamentos::orderBy('nombre')->get();
        //return $idesigue;
          // mando llamar a la vista altaempleado y el asigno el idesigue con el valor
          // de la variable $idesigue
        return view('altaempleado')
        ->with('idsigue',$idesigue)
        ->with('depas',$departamentos);
    }

    // hay que poner Request para mandar los datos a las variables
    public function guardarempleado(Request $request){

        //return view('altaempleado');
        // se envia en forma de arreglo toda la info
        //return $request;
        // enviar de otra forma la informacion como tipo debug
        //dd($request);
                   // este es el nombre del input
        // $nombre = $request->nombre;
        // $sexo = $request->sexo;
        // para hacer validaciones, reglas de validacion
        $this->validate($request,[
            // con esta regla se pueden agregar cualquier letra de la A a la Z
            // 'ide' => 'required|regex:/^[A-Z]{3}[-][0-9]{5}$/',
            //'ide' => 'required|regex:/^[E][M][P][-][0-9]{5}$/',
            'nombre' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            // si le pongo asterisco en lugar del mas, es para indicar que lleva un numero o no antes del
            //punto decimal
            //'apellido' => 'required|regex:/^[0-9]+[.][0-9]{2}$/',
            //'apellido' => 'required|regex:/^[0-9]*[.][0-9]{2}$/',
            'apellido' => 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'email' => 'required|email',
            'celular' => 'required|regex:/^[0-9]{10}$/',
            //agregar la validacion para subir solo estos tipos de archivos
            'img' => 'image|mimes:gif,jpg,png'
        ]);


        $file = $request->file('img');
        // creamos la validacion por si el usuario no ingresa una foto, en automatico el sistema registre la foto llamada sinfoto.png
        if($file<>"") {
        // esta instruccion es para obtener la ruta original del archivo
        $img = $file->getClientOriginalName();
        // si dos usuarios suben la misma imagen con el mismo nombre hacemos esto para evitar que se reemplacen
        $img2 = $request->ide . $img;
        \Storage::disk('local')->put($img2,\File::get($file));
        } else {
            $img2 = "sinfoto.png";
        }

        $empleados = new empleados;
        $empleados->ide=$request->ide;
        $empleados->nombre=$request->nombre;
        $empleados->apellido=$request->apellido;
        $empleados->email=$request->email;
        $empleados->celular=$request->celular;
        $empleados->sexo=$request->sexo;
        $empleados->descripcion=$request->descripcion;
        $empleados->idd=$request->idd;
        // guardamos el nombre de la ruta
        $empleados->img = $img2;
        $empleados->save();

       /* return view('mensajes')
       ->with('proceso',"ALTA DE EMPLEADOS")
       ->with('mensaje',"El empleado $request->nombre $request->apellido ha sido dado de alta correctamente")
       ->with('error',1); */

       Session::flash('mensaje',"El empleado $request->nombre $request->apellido ha sido dado de alta correctamente");
       return  redirect()->route('reporteempleados');
    }
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

        $consulta = empleados::select(['nombre','apellido','edad'])
                            ->where('edad','>=',30)
                            ->get();
        $consulta = empleados::select(['nombre','apellido','edad'])
                            ->where('apellido','LIKE','%rre%')
                            ->get();
        $consulta = empleados::where('sexo','F')->sum('salario');

        // consulta con agrupamiento
        $consulta = empleados::groupBy('sexo')
                    ->selectRaw('sexo,sum(salario) as salioT')
                    ->get();

        $consulta = empleados::groupBy('sexo')
                    ->selectRaw('sexo,count(*) as Personas')
                    ->get();

        /* SQL = "SELECT e.ide, e.nombre, d.nombre AS departamento, e.edad
        FROM empleados AS e
        INNER JOIN departamentos AS d ON d.idd = e.idd
        WHERE e.edad >= 30" */

            //consulta en eloquent
        $consulta = empleados::join('departamentos','empleados.idd','=','departamentos.idd')
                ->select('empleados.ide','empleados.nombre','departamentos.nombre as depa','empleados.edad')
                ->where('empleados.edad','>=',30)
                ->get();

                    // ejemplo con and o or
        $consulta = empleados::where('edad','>=',40)
                ->orwhere('sexo','F')
                ->get();

        //$cuantos = count($consulta);

        return $consulta;

    }

   /*  public function altaempleado(){

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
    } */
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
