<?php
require_once '../modelos/db.php';

session_start();

$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];

if (!isset($cedula)) {
    // El usuario no ha iniciado sesión
    header('Location: home');
}
       
?>

<?php require_once 'comunes/header.php';?>

<div class="container-xl" style="padding:0;  margin-bottom: -50px;">
    <div class='fondoespecial' style="padding-bottom:50px;">

        <div class="contenedor-h2" >
            <h2 class="casos" style='color: #fff;'>CASOS</h2>
            <h2 class="clinicos" style='color: #fff;'>CLÍNICOS</h2>
        </div>

        <div class="row align-items-stretch">

            <?php
                // Verificar si la conexión fue exitosa
                if (!$conn) {
                    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
                }

                // Consulta para obtener los casos clínicos
                $query = "SELECT * FROM pacientes WHERE estaHabilitada = 1";
                $resultado = mysqli_query($conn, $query);

                // Verificar si se encontraron resultados
                if (mysqli_num_rows($resultado) > 0) {
                    // Mostrar los casos clínicos
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<div class='col-lg-4 col-md-6 col-sm-12 mb-3'>";
                        echo "<div class='relativediv'>";
                        echo "<div class='imagenPaciente'>";
                        echo "<img src='public/img/pacientes/card/" . $row['nombre'] . '.png'. "' alt=''>";
                        echo "</div>";
                        echo "<div class='cuerpocard'>";
                        echo "<h2 class='sistemah2'>" . $row['nombre'] . "</h2>";
                        echo "<h3 class='sistemah3'>" . $row['edad'] ."</h3>";
                        echo "<p class='descripcionp'>" . $row['descripcion'] . "</p>";
                        echo "</div>";
                        echo "<div class='enlacecard'>";
                        echo "<a class='veraquia' href='casoclinico?id=".$row['ID']."'>VER AQUÍ</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";

                    }
                } else {
                    // No se encontraron casos clínicos
                    echo "<div class='col-md-12'>";
                    echo "<h2>No se encontraron casos clínicos</h2>";
                    echo "</div>";
                }
            ?>
            
             
        </div>
    </div>
</div>



<?php 
mysqli_close($conn);
require_once 'comunes/footer.php';
require_once 'btn-homeclinicos.php';
?>
