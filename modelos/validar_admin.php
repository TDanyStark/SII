<?php
session_start();

require_once 'db.php';

// Verificar si la conexión fue exitosa
if (!$conn) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

// Obtener los datos enviados por POST
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Consulta para verificar si el usuario existe en la base de datos
$query = "SELECT * FROM admins WHERE usuario = '$usuario'";
$resultado = mysqli_query($conn, $query);

// Verificar si se encontraron resultados
if (mysqli_num_rows($resultado) > 0) {
    // Verificar si la contraseña es correcta
    $row = mysqli_fetch_assoc($resultado);
    if ($contraseña == $row['contraseña']) {
        // La contraseña es correcta
        // Iniciar sesión
        $_SESSION['admin'] = $usuario;
        echo 'existe';
    } else {
        // La contraseña es incorrecta
        echo 'contraseña_incorrecta';
    }
} else {
    // El usuario no existe en la base de datos
    echo 'usuario_incorrecto';
}
