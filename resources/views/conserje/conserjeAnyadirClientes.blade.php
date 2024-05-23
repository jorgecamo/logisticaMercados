@extends('plantillaConserje')
@section('titulo', 'Vista Conserje Añadir Clientes')
@section('contenido')

    <p class="mb-4 fs-2 fw-bold text-center">Añadir clientes</p>
    <div class="container">
        <form class="formularioClientes" action="{{ route('conserje.anyadirClientes') }}" method="post">
            @csrf
            <table class="table table-striped" id="anyadirClientes">
                <thead class="thead-dark">
                    <tr>
                        <th class="fs-3">Nombre</th>
                        <th class="fs-3">DNI</th>
                        <th class="fs-3">Teléfono</th>
                        <th class="fs-3">Correo</th>
                        <th class="fs-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fs-3"><input type="text" name="nombre" class="form-control"
                                placeholder="Introduce el nombre del nuevo cliente" pattern="^[A-Z][a-z]+(?: [A-Z][a-z]+)*$"
                                title="Introduce el nombre del cliente." required>
                        </td>
                        <td class="fs-3"><input type="text" name="DNI" class="form-control"
                                placeholder="Introduce el DNI del nuevo cliente" pattern="[0-9]{8}[A-Za-z]{1}"
                                title="DNI debe tener al menos 8 numeros y una letra." required>
                        </td>
                        <td class="fs-3">
                            <input type="tel" name="telefono" class="form-control"
                                placeholder="Introduce el telefono del nuevo cliente" pattern="\d{9}"
                                title="El teléfono debe tener entre 9 dígitos." required>
                        </td>
                        <td class="fs-3">
                            <input type="email" name="correo" class="form-control"
                                placeholder="Introduce el correo del nuevo cliente"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Introduce el correo del nuevo cliente." required>
                        </td>

                        <td><input type="hidden" name="Id_mercado" value="{{ $Id_mercado }}"></td>
                        <td><button type="submit" class="btn fs-5" style="background-color: #009483; color:#ffffff">Añadir Cliente</button></td>
                    </tr>
                </tbody>

            </table>
        </form>
    </div>

@endsection
