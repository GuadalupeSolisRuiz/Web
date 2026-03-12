<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión | Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #4b2394 0%, #6f42c1 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 100%; max-width: 400px; }
        .btn-purple { background: #6f42c1; color: white; border: none; }
        .btn-purple:hover { background: #4b2394; color: white; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <i class="bi bi-mortarboard-fill" style="font-size: 3rem; color: #6f42c1;"></i>
        <h3 class="fw-bold">Bienvenido</h3>
        <p class="text-muted">Ingresa tus credenciales</p>
    </div>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger p-2 text-center" style="font-size: 0.8rem;">
            Correo o contraseña incorrectos
        </div>
    <?php endif; ?>

    <form action="validar.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="correo" class="form-control" placeholder="ejemplo@escuela.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" name="btn_entrar" class="btn btn-purple w-100 py-2 fw-bold mt-3">Iniciar Sesión</button>
    </form>
</div>

</body>
</html>