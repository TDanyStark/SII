<?php
require_once '../modelos/db.php';

session_start();

$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];

if (!isset($cedula)) {
    // El usuario no ha iniciado sesión
    header('Location: home');
}
       

require_once 'comunes/header.php';


if (!$conn) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}


$id= $_GET['id'];

// verigicar si existe el id por get
if (!isset($id)) {
    // El usuario no ha iniciado sesión
    header('Location: home');
}


// Consulta para obtener los casos clínicos
$query = "SELECT * FROM pacientes WHERE ID = '$id'";
$resultado = mysqli_query($conn, $query);


// Verificar si se encontraron resultados

if (mysqli_num_rows($resultado) > 0) {
    // Mostrar los casos clínicos
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo $row['codigoHTML'];
        echo "<a href='tratamiento?id=".$row['ID']."' class='btn-tratamiento'>SELECCIONE EL TRATAMIENTO PARA ".$row['nombre']." </a>";
        echo "</div>";
    }
} else {
    // No se encontraron casos clínicos
    echo "<div class='col-md-12'>";
    echo "<h2>No se encontraron casos clínicos</h2>";
    echo "</div>";
    echo "</div>";

}
mysqli_close($conn);

require_once 'comunes/footer.php';
?>
<?php require_once 'btn-homeclinicos.php';?>


