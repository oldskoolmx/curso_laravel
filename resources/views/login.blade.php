@extends('vistaboostrap')

@section('contenido')
    <div class="container">
        <h1>Inicio de Sesion</h1>
        <hr>
        {{-- para agregar archivos al formulario hay que agregar enctype = 'multipart' --}}
        <form action="{{ route('validar') }}" method="POST">

            {{ csrf_field() }} {{-- hay que agregar un token, todos los formularios deben de llevarlo --}}

            <div class="well">

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="nombre">Usuario:
                                @if ($errors->first('usuario'))
                                    <p class="text-danger">{{ $errors->first('usuario') }}</p>
                                @endif
                            </label>
                            <input type="text" name="usuario" id="usuario" value="" class="form-control"
                                placeholder="Usuario" tabindex="1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="apellido">Password:
                                @if ($errors->first('pasw'))
                                    <p class="text-danger">{{ $errors->first('pasw') }}</p>
                                @endif
                            </label>
                            <input type="text" name="pasw" id="pasw" value="" class="form-control"
                                placeholder="Password" tabindex="2">
                        </div>
                    </div>
                </div>




                <br>
                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" value="Iniciar"
                            class="btn btn-danger btn-block btn-lg" tabindex="7" title="Iniciar">
                    </div>
                </div>
        </form>
        <br>
        <br>
        {{-- alerta flash para enviar una alerta por si no existe el usuario o la contraseña es invalida --}}
        @if (Session::has('mensaje'))
            <div class="alert alert-danger">{{ Session::get('mensaje') }}</div>
        @endif
    @stop
