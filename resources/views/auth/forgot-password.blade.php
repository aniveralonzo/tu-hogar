<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar contraseña | Tu Hogar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column align-items-center justify-content-center">
    <div class="card login-card shadow-lg w-100 mx-3">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 text-center fw-bold mb-2 auth-titulo">Recuperar contraseña</h1>
            <p class="text-center text-muted mb-4">Escribe tu correo y te enviaremos un enlace para crear una nueva contraseña.</p>

            @if (session('status'))
            <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Correo</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control" required autofocus>
                </div>
                <button type="submit" class="btn btn-th w-100 py-2">ENVIAR ENLACE</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="small">Volver a iniciar sesión</a>
            </div>
        </div>
    </div>
</body>

</html>