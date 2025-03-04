<h1>Restablecer contraseña</h1>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <label for="email">Correo electrónico:</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    <button type="submit">Continuar</button>
    <a href="{{ route('login') }}">Cancelar</a>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
</form>