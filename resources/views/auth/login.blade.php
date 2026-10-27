<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Tu Hogar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Estilos propios, en public/css/auth.css --}}
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column align-items-center justify-content-center">
    <div class="card login-card shadow-lg w-100 mx-3">
        <div class="card-body p-4 p-md-5">
            <h1 class="h2 text-center fw-bold mb-1 auth-titulo">Tu <span class="acento">Hogar</span></h1>
            <p class="text-center text-muted mb-4">Inicia sesión para continuar</p>

            {{-- Aviso después de restablecer la contraseña --}}
            @if (session('status'))
            <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif

            {{-- Errores de login --}}
            @if ($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Usuario (correo)</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control" required autofocus autocomplete="username">
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" name="password"
                        class="form-control" required autocomplete="current-password">
                </div>
                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="small">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-th w-100 py-2">INICIAR SESIÓN</button>
            </form>
        </div>
    </div>
    <small class="text-white-50 mt-3">Hazlo tú mismo!!!</small>
</body>

</html>