<?php
session_start();
include 'includes/db.php';

// Verificación de seguridad: solo maestros o sistemas
if ($_SESSION['rol'] == 3) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['btn_subir_nota'])) {
    $id_alumno = $_POST['id_alumno'];
    $materia   = mysqli_real_escape_string($conn, $_POST['materia']);
    $p1        = $_POST['p1'];
    $p2        = $_POST['p2'];

    // Insertamos la calificación
    $sql = "INSERT INTO calificaciones (id_alumno, materia, parcial1, parcial2) 
            VALUES ('$id_alumno', '$materia', '$p1', '$p2')";

    if (mysqli_query($conn, $sql)) {
        // Regresamos al dashboard con un mensaje de éxito
        header("Location: dashboard.php?status=nota_guardada");
    } else {
        echo "Error al guardar: " . mysqli_error($conn);
    }
}
?>