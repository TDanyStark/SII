<?php
// Datos de configuración de la base de datos
define('DB_HOST', 'localhost'); // Host de la base de datos
define('DB_USER', 'root'); // Nombre de usuario de la base de datos
define('DB_PASSWORD', ''); // Contraseña de la base de datos
define('DB_NAME', 'sistemasii'); // Nombre de la base de datos

// Establecer la conexión a la base de datos
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>
