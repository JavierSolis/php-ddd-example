<h1>Detalle de Usuario</h1>

<p><strong>Nombre:</strong> {{ $usuario->usuarioNombre }}</p>
<p><strong>Alias:</strong> {{ $usuario->usuarioAlias }}</p>
<p><strong>Email:</strong> {{ $usuario->usuarioEmail }}</p>
<p><strong>Estado:</strong> {{ $usuario->usuarioEstado }}</p>
<p><strong>Última Conexión:</strong> {{ $usuario->usuarioUltimaConexion }}</p>

<a href="{{ route('usuarios.catalogo') }}">Volver al listado</a>

<a href="{{ route('usuarios.adjuntarFotoForm', $usuario->idUsuario) }}">
    <button>Adjuntar Foto</button> </a>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif