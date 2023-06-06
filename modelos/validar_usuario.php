<?php
session_start();

require_once 'db.php';

// Verificar si la conexión fue exitosa
if (!$conn) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

// Obtener los datos enviados por AJAX
$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];
$fecha = date('Y-m-d');


// Consulta para verificar si el usuario existe en la base de datos
$query = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
$resultado = mysqli_query($conn, $query);

// Verificar si se encontraron resultados
if (mysqli_num_rows($resultado) > 0) {
    // El usuario existe en la base de datos
    // Actualizar la fecha de ingreso del usuario
    $query = "UPDATE usuarios SET ultimafechaingreso = '$fecha' WHERE cedula = '$cedula'";
    #redirigir a la pagina de sistema


    # ver el nombre del usuario en la base de datos
    $nombreDB = "SELECT nombre FROM usuarios WHERE cedula = '$cedula'";
    $resultadoNombre = mysqli_query($conn, $nombreDB);
    $nombreenDB = mysqli_fetch_assoc($resultadoNombre)['nombre'];

    $_SESSION['cedula'] = $cedula;
    $_SESSION['nombre'] = $nombreenDB;

    echo 'existe';

} else {
    # si no existe el nombre no se puede registrar
    if ($nombre == '') {
        echo 'No se puede registrar sin nombre';
    }else{
         // El usuario no existe en la base de datos, realizar el registro
        $query = "INSERT INTO usuarios (cedula, nombre, ultimafechaingreso) VALUES ('$cedula', '$nombre', '$fecha')";
        if (mysqli_query($conn, $query)) {
            // Registro exitoso
            echo 'registro_exitoso';
            $_SESSION['cedula'] = $cedula;
            $_SESSION['nombre'] = $nombre;
        } else {
            // Error al realizar el registro
            echo 'error_registro';
        }
    }

   
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>