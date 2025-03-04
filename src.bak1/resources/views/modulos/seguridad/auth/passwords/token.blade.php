<h1>Verificar código</h1>

<form method="POST" action="{{ route('password.token.verify') }}">
    @csrf

    <input type="hidden" name="email" value="{{ $email }}">  </input>

    <label for="token">Código de verificación:</label>
    <input id="token" type="text" name="token" required autofocus>

    <button type="submit">Verificar</button>
    <a href="{{ route('password.email') }}">Volver</a>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</form>