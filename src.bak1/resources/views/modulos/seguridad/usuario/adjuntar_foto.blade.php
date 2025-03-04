<h1>Adjuntar Foto</h1>

<form action="{{ route('usuarios.adjuntarFoto', $usuario->idUsuario) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="foto">
    <button type="submit">Aceptar</button>
    <a href="{{ route('usuarios.detalle', $usuario->idUsuario) }}">
        <button type="button">Cancelar</button>
    </a>
    <p>{{ session('success') }} {{ session('error') }}</p>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif
@if ($errors->any())
    <p style="color: red;">Solo se permiten imágenes .jpg, .jpeg o .png.</p>
@endif

</form>


@if (session('success'))
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('usuarios.detalle', $usuario->idUsuario) }}";
        }, 3000); // 3000 milisegundos = 3 segundos
    </script>
@endif