<?php
session_start();

require_once 'db.php';

// Verificar si la conexión fue exitosa
if (!$conn) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}


// Obtener los datos de la petición
$cardName = $_POST['cardName'];

// Preparar la consulta con un marcador de posición (?)
$sql = "UPDATE pacientes SET estaHabilitada = 1 WHERE nombre = ?";

// Preparar la sentencia
$stmt = $conn->prepare($sql);

// Asignar el valor a la variable del marcador de posición (?)
$stmt->bind_param("s", $cardName);

// Ejecutar la consulta
$stmt->execute();

// Verificar si la consulta se ejecutó correctamente
if ($stmt->affected_rows > 0) {
    echo "Card habilitada";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Cerrar la sentencia y la conexión
$stmt->close();

?>