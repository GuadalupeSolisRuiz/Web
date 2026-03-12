<?php
session_start();
include 'includes/db.php';

$id_usuario = $_SESSION['usuario_id'];

$motivo = $_POST['motivo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

$sql = "INSERT INTO citas (id_usuario,motivo,fecha,hora)
VALUES ('$id_usuario','$motivo','$fecha','$hora')";

mysqli_query($conn,$sql);

header("Location: dashboard.php?cita=ok");
?>