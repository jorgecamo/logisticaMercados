@extends('plantillaConserje')
@section('titulo', 'Vista Conserje Añadir Clientes')
@section('contenido')

    <h1>Añadir clientes</h1>
    <form class="formularioClientes" action="{{ route('conserje.anyadirClientes') }}" method="post">
        @csrf
        <table class="table table-striped" id="anyadirClientes">
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td><input type="text" name="nombre" class="form-control"
                        placeholder="Introduce el nombre del nuevo cliente" pattern="^[A-Z][a-z]+(?: [A-Z][a-z]+)*$" required>
                </td>
                <td><input type="text" name="DNI" class="form-control"
                        placeholder="Introduce el DNI del nuevo cliente" pattern="[0-9]{8}[A-Za-z]{1}"
                        title="DNI debe tener al menos 8 numeros y una letra." required>
                </td>
                <td>
                    <input type="tel" name="telefono" class="form-control"
                        placeholder="Introduce el telefono del nuevo cliente" pattern="\d{9}"
                        title="El teléfono debe tener entre 9 dígitos." required>
                </td>
                <td>
                    <input type="email" name="correo" class="form-control"
                        placeholder="Introduce el correo del nuevo cliente" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        required>
                </td>

                <td><input type="hidden" name="Id_mercado" value="{{ $Id_mercado }}"></td>
                <td><button type="submit" class="btn btn-primary">Añadir Cliente</button></td>
            </tr>
        </table>
    </form>
@endsection
