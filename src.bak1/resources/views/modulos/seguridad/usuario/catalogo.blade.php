<h1>Listado de Usuarios</h1>

<ul>
    @foreach ($usuarios as $usuario)
        <li>
            <a href="{{ route('usuarios.detalle', $usuario->idUsuario) }}">
                {{ $usuario->usuarioNombre }}
            </a>
        </li>
    @endforeach
</ul>