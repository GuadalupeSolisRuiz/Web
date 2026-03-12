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
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
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
            <span class="fs-4 fw-bold">Colegio Americano</span>
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

            <li><a href="cita.php" class="nav-link"><i class="bi bi-building me-2"></i> Cita al Plantel</a></li>
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
            <?php if(isset($_GET['status']) && $_GET['status'] == 'nota_guardada'): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <strong>¡Éxito!</strong> La calificación se ha registrado correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(isset($_GET['cita'])): ?>
<div class="alert alert-success">
La cita fue registrada correctamente
</div>
<?php endif; ?>

<h2 class="mb-4 text-secondary">Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm p-4 mb-4">
    <h5 class="fw-bold text-purple"><i class="bi bi-star-fill me-2"></i> Mis Calificaciones</h5>
    <table class="table mt-3 align-middle">
            
        <tbody>
            <?php
            // Obtenemos el ID del alumno que está logueado
            $id_logeado = $_SESSION['usuario_id'];

            // Consultamos solo las materias de este alumno
            $query_calif = "SELECT * FROM calificaciones WHERE id_alumno = '$id_logeado'";
            $res_calif = mysqli_query($conn, $query_calif);

            // Si el alumno tiene calificaciones, las mostramos
            if (mysqli_num_rows($res_calif) > 0) {
                while($reg = mysqli_fetch_assoc($res_calif)) {
                    $promedio = ($reg['parcial1'] + $reg['parcial2']) / 2;
                    $clase_badge = ($promedio >= 7) ? 'bg-success' : 'bg-danger';
            ?>
                <tr>
                    <td><?php echo $reg['materia']; ?></td>
                    <td><?php echo $reg['parcial1']; ?></td>
                    <td><?php echo $reg['parcial2']; ?></td>
                    <td><span class="badge <?php echo $clase_badge; ?>"><?php echo number_format($promedio, 1); ?></span></td>
                </tr>
            <?php 
                } 
            } 
            ?>
           
            <?php if($rol == 1 || $rol == 2): // Se guardan las calificaciones si es maestro ?> 
<div class="card border-0 shadow-sm p-4 mt-4">
    <h5 class="fw-bold text-purple"><i class="bi bi-pencil-fill me-2"></i> Capturar Calificaciones</h5>
    <form action="procesar_notas.php" method="POST" class="row g-3 mt-2">
        <div class="col-md-4">
            <label class="form-label">Seleccionar Alumno</label>
            <select name="id_alumno" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php
                // Traemos solo a los que son alumnos (Rol 3)
                $res_alumnos = mysqli_query($conn, "SELECT id, nombre FROM usuarios WHERE rol = 3");
                while($al = mysqli_fetch_assoc($res_alumnos)){
                    echo "<option value='".$al['id']."'>".$al['nombre']."</option>";
                }
                ?>
                
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Materia</label>
            <input type="text" name="materia" class="form-control" placeholder="Ej: Redes Cisco" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Parcial 1</label>
            <input type="number" step="0.1" name="p1" class="form-control" min="0" max="10" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Parcial 2</label>
            <input type="number" step="0.1" name="p2" class="form-control" min="0" max="10" required>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" name="btn_subir_nota" class="btn btn-purple w-100">
                <i class="bi bi-save"></i>
            </button>
        </div>
    </form>
</div>
<?php if($rol == 1 || $rol == 2): // Solo Sistemas y Maestros ?>
    <div class="card border-0 shadow-sm p-4 mt-4">
        <h5 class="fw-bold text-purple mb-3">Historial de Calificaciones Registradas</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Alumno</th>
                        <th>Materia</th>
                        <th>P1</th>
                        <th>P2</th>
                        <th>Promedio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Esta consulta une la tabla calificaciones con usuarios para ver el nombre del alumno
                    $sql_listado = "SELECT c.*, u.nombre as alumno_nombre 
                                    FROM calificaciones c 
                                    INNER JOIN usuarios u ON c.id_alumno = u.id 
                                    ORDER BY c.id DESC";
                    $res_listado = mysqli_query($conn, $sql_listado);

                    while($reg = mysqli_fetch_assoc($res_listado)):
                        $prom = ($reg['parcial1'] + $reg['parcial2']) / 2;
                    ?>
                    <tr>
                        <td><strong><?php echo $reg['alumno_nombre']; ?></strong></td>
                        <td><?php echo $reg['materia']; ?></td>
                        <td><?php echo $reg['parcial1']; ?></td>
                        <td><?php echo $reg['parcial2']; ?></td>
                        <td><span class="badge bg-purple" style="background: var(--purple-primary);"><?php echo number_format($prom, 1); ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>
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

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>