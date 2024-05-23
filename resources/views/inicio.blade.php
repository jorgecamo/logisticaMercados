@extends('plantilla')
@section('titulo', 'Inicio')
@section('contenido')

<div class="d-flex flex-column justify-content-center align-items-center" id="contenedorLogin">
        <p class=" fs-1">Logística Mercados</p>
    <img src="{{ asset('images/logotipo.png')}}" alt="Imagen Logotipo" class="mb-4">
    <form class="formularioLogin mb-5" action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="form-group mb-4"> 
            <label for="usuario" class="fs-3">Usuario</label>
            <input type="text" class="form-control" name="usuario" required>
        </div>


        <div class="form-group mb-4">
            <label for="contrasena" class="fs-3">Contraseña</label>
            <input type="password" class="form-control" name="contrasena" required>
        </div>

        <div class="botones mb-6 text-center"> 
            <button type="submit" class="btn btn-lg me-5" style="background-color: #009483; color:#ffffff">Enviar</button>
            <button type="reset" class="btn btn-lg" style="background-color: #006358; color:#ffffff">Borrar</button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                {{ $errors->first('usuario') }}
                {{ $errors->first('contrasena') }}
            </div>
        @endif
    </form>
</div>


    <script>
        // Limpiar el localStorage al hacer logout
        localStorage.removeItem('formularioEnviado');
    </script>

@endsection
