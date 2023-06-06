<?php
session_start();

require_once 'db.php';

// Verificar si la conexión fue exitosa
if (!$conn) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

$cedula = $_POST['cedula'];
$NamePaciente = $_POST['nombre'];


// update the users's interaction with the card add 1 to the card in the table interacciones
$sql = "UPDATE interacciones SET $NamePaciente = $NamePaciente + 1, ultima_interaccion = CURRENT_TIMESTAMP() WHERE UsuarioCedula = '$cedula'";
$result = mysqli_query($conn, $sql);

// if the user has not interacted with the card before, insert the user in the table interacciones
if (mysqli_affected_rows($conn) == 0) {
    $sql = "INSERT INTO interacciones (UsuarioCedula, $NamePaciente, ultima_interaccion) VALUES ('$cedula', 1, CURRENT_TIMESTAMP())";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 0) {
        echo 'error';
    } else {
        echo 'registro_exitoso';
    }

} else {
    echo 'Actualizacion_exitosa';
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>