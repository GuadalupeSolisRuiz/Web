<?php
session_start();
include 'includes/db.php'; // <--- ESTA LÍNEA ES LA MÁS IMPORTANTE

if(!isset($_SESSION['usuario_id'])) { 
    header("Location: login.php"); 
    exit();
}
$rol = $_SESSION['rol']; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Escolar | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --purple-primary: #6f42c1; --purple-dark: #4b2394; }
        body { background-color: #f8f9fa; }
        .sidebar { width: 280px; height: 100vh; background: var(--purple-dark); color: white; position: fixed; }
        .main-content { margin-left: 280px; padding: 20px; }
        .nav-link { color: rgba(255,255,255,0.8); margin: 5px 0; }
        .nav-link:hover, .nav-link.active { background: var(--purple-primary); color: white; border-radius: 8px; }
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 15px; }
        .text-purple { color: var(--purple-primary); }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar d-flex flex-column p-3">
        <div class="d-flex align-items-center mb-4 text-white text-decoration-none">
            <i class="bi bi-mortarboard-fill fs-2 me-2"></i>
            <span class="fs-4 fw-bold">Nombre Escuela</span>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-house-door me-2"></i> Inicio</a></li>
            
            <?php if($rol == 3): // ALUMNOS ?>
                <li><a href="#" class="nav-link"><i class="bi bi-calendar3 me-2"></i> Horario</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-journal-check me-2"></i> Historial Académico</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-graph-up me-2"></i> Promedio Periodo</a></li>
            <?php endif; ?>

            <?php if($rol == 2 || $rol == 1): // MAESTROS Y SISTEMAS ?>
                <li><a href="#" class="nav-link"><i class="bi bi-people me-2"></i> Lista de Alumnos</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-pencil-square me-2"></i> Captura de Calificaciones</a></li>
            <?php endif; ?>

            <?php if($rol == 1): // SOLO SISTEMAS ?>
                <li><a href="#gestion-usuarios" class="nav-link"><i class="bi bi-gear me-2"></i> Gestión de Usuarios</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-database-fill me-2"></i> Respaldos</a></li>
            <?php endif; ?>

            <li><a href="#" class="nav-link"><i class="bi bi-building me-2"></i> Cita al Plantel</a></li>
        </ul>
    </div>

    <div class="main-content w-100">
        <nav class="navbar navbar-custom d-flex justify-content-end mb-4">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userMenu" data-bs-toggle="dropdown">
                    <img src="https://via.placeholder.com/32" alt="" class="rounded-circle me-2">
                    <strong><?php echo $_SESSION['nombre']; ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Cuenta</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <h2 class="mb-4 text-secondary">Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm p-4 mb-4">
                        <h5 class="fw-bold text-purple"><i class="bi bi-star-fill me-2"></i> Resumen de Calificaciones</h5>
                        <table class="table mt-3">
                            <thead class="table-light">
                                <tr><th>Materia</th><th>P1</th><th>P2</th><th>Promedio</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Programación Web</td><td>9.5</td><td>10</td><td><span class="badge bg-success">9.8</span></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <?php if($rol == 1): ?>
                    <div id="gestion-usuarios" class="card border-0 shadow-sm p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-purple">Gestión de Usuarios </h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                                <i class="bi bi-plus-lg"></i> Nuevo Usuario
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM usuarios";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_assoc($result)):
                                        $lbl_rol = ($row['rol']==1)?'Sistemas':(($row['rol']==2)?'Maestro':'Alumno');
                                        $color = ($row['rol']==1)?'bg-dark':(($row['rol']==2)?'bg-primary':'bg-info');
                                    ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><?php echo $row['correo']; ?></td>
                                        <td><span class="badge <?php echo $color; ?>"><?php echo $lbl_rol; ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                            <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar usuario?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-white" style="background: var(--purple-primary);">
                        <h6>Avisos Recientes</h6>
                        <small>No olvides realizar tu evaluación docente antes del viernes.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <form action="procesar_usuario.php" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: var(--purple-dark);">
                <h5 class="modal-title">Registrar Nuevo Miembro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Nombre Completo</label><input type="text" name="nombre" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Correo Institucional</label><input type="email" name="correo" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-3">
                    <label class="form-label">Asignar Rol</label>
                    <select name="rol" class="form-select">
                        <option value="3">Alumno</option>
                        <option value="2">Maestro</option>
                        <option value="1">Sistemas</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" name="btn_guardar" class="btn btn-success w-100">Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>