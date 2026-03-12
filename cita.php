<?php
session_start();
include 'includes/db.php';

$id_usuario = $_SESSION['usuario_id'];

$query = mysqli_query($conn,"SELECT * FROM usuarios WHERE id='$id_usuario'");
$usuario = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Agendar Cita</title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card shadow p-4">

<h4>Agendar Cita al Plantel</h4>

<form action="guardar_cita.php" method="POST">

<div class="mb-3">
<label>Nombre</label>
<input type="text" class="form-control" value="<?php echo $usuario['nombre']; ?>" readonly>
</div>

<div class="mb-3">
<label>Correo</label>
<input type="email" class="form-control" value="<?php echo $usuario['correo']; ?>" readonly>
</div>

<div class="mb-3">
<label>Motivo de la cita</label>
<textarea name="motivo" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Fecha</label>
<input type="date" name="fecha" class="form-control" required>
</div>

<div class="mb-3">
<label>Hora</label>
<input type="time" name="hora" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary">Agendar Cita</button>

</form>

</div>
</div>

</body>
</html>

?>