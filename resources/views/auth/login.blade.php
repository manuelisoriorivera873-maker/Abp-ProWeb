<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; height: 100vh; display: flex; align-items: center; }
        .card { border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-primary { border-radius: 8px; padding: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h2 class="text-center mb-4 fw-bold text-primary">Bienvenido</h2>
                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="gabriel@gmail.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        <div class="text-center mt-3">
                            <span class="text-muted">¿No tienes cuenta?</span> 
                            <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Regístrate aquí</a>
                        </div>
                    </form>
                    @if($errors->any())
                        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>