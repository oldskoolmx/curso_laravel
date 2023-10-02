<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\usuarios;
use Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function login()
    {
        //
        return view('login');
    }
    public function principal()
    {
        //


        $sessionidu = session('sessionidu');
        if($sessionidu<>""){

            return view('vistaboostrap');
        } else {
            Session::flash('mensaje',"Logearser antes de continuar");
            return redirect()->route('login');
        }


    }

    public function validar(Request $request){
        $this->validate($request,[

            'usuario' => 'required',
            'pasw' => 'required'

        ]);

         //$paswordEncriptado = Hash::make($request->pasw);
        //echo $paswordEncriptado;

         $consulta = usuarios::where('user',$request->usuario)
        ->where('activo','si')
        ->get();

        $cuantos = count($consulta);

        //echo $cuantos;
                                        // checa que lo que el usuario teclea con lo que esta registrado en la BD
         //if($cuantos==1 and hash::check($request->pasw,$consulta[0]->pasw)) {
         if($cuantos >= 1 and hash::check($request->pasw,$consulta[0]->pasw)) {
            // si coinciden todas la validaciones los mande a la vista principal
            Session::put('sessionusuario',$consulta[0]->nombre.' '.$consulta[0]->apellido);
            Session::put('sessiontipo',$consulta[0]->tipo);
            Session::put('sessionidu',$consulta[0]->idu);
            return  redirect()->route('principal');
        }
        else {
            Session::flash('mensaje',"El usuario o password no son validos");
            return  redirect()->route('login');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
