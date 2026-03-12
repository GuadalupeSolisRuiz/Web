<?php
include 'includes/db.php';

if (isset($_POST['btn_guardar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = md5($_POST['password']); // Seguridad avanzada
    $rol = $_POST['rol'];

    // Insertar en la BD (Create del CRUD)
    $sql = "INSERT INTO usuarios (nombre, correo, password, rol) VALUES ('$nombre', '$correo', '$password', '$rol')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?msg=usuario_creado");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>