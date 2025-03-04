<h1>Nueva contraseña</h1>

<p>Restablecer contraseña para: {{ $email }}</p>

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="email" value="{{ $email }}">

    <label for="password">Contraseña:</label>
    <input id="password" type="password" name="password" required>

    <label for="password-confirm">Confirmar contraseña:</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <button type="submit">Guardar</button>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</form>