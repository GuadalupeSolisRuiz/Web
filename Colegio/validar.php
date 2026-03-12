<?php
// 1. Iniciamos la sesión para poder guardar los datos del usuario
session_start();

// 2. Incluimos la conexión a la base de datos
include 'includes/db.php'; 

if (isset($_POST['btn_entrar'])) {
    // 3. Recibimos el correo y la contraseña del formulario de login
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $password = md5($_POST['password']);

    // 4. Buscamos si existe un usuario con ese correo
    $consulta = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conn, $consulta);

    if ($filas = mysqli_fetch_assoc($resultado)) {
        
        // 5. Verificamos la contraseña 
        // Nota: Aquí comparamos directo. Si usaste password_hash al crear, usa password_verify()
        if ($password == $filas['password']) {
            
            // ¡ÉXITO! Guardamos los datos en la SESIÓN
            $_SESSION['usuario_id'] = $filas['id'];
            $_SESSION['nombre']     = $filas['nombre'];
            $_SESSION['rol']        = $filas['rol'];

            // Nos vamos al Dashboard ya con los datos cargados
            header("Location: dashboard.php");
            exit();
            
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // El correo no existe en la base de datos
        header("Location: login.php?error=1");
        exit();
    }
} else {
    // Si alguien intenta entrar a validar.php sin pasar por el login, lo regresamos
    header("Location: login.php");
    exit();
}
?>