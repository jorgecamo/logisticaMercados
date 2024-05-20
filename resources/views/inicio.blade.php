@extends('plantilla')
@section('titulo', 'Inicio')
@section('contenido')

<h1>Página de inicio</h1>
<form class="formularioLogin" action="{{ route('login.store') }}" method="POST">
    @csrf
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario" required>
    <label for="contrasena">Contraseña</label>
    <input type="password" name="contrasena" required>
    <div class="botones">
        <button type="submit" class="btn btn-primary">Enviar</button>
        <button type="reset" class="btn btn-danger">Borrar</button>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        {{$errors->first('usuario')}}
        {{$errors->first('contrasena')}}
    </div>
    @endif
</form>

<script>
    // Limpiar el localStorage al hacer logout
    localStorage.removeItem('formularioEnviado');
</script>

@endsection