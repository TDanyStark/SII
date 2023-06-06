<?php
require_once '../../modelos/db.php';

session_start();

$admin = $_SESSION['admin'];

if (!isset($admin)) {
    // El usuario no ha iniciado sesión
    header('Location: admin');
}

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT usuarios.Cedula, usuarios.Nombre, interacciones.SONIA, interacciones.IAN, interacciones.INGRID, interacciones.SANDRA, interacciones.IGNACIO, interacciones.IVANNA, interacciones.SANTIAGO, interacciones.ISABEL, interacciones.IVÁN, 
DATE_ADD(interacciones.ultima_interaccion, INTERVAL 1 HOUR) AS ultima_interaccion
FROM usuarios JOIN interacciones ON usuarios.Cedula = interacciones.UsuarioCedula";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SII</title>
    <link rel="shortcut icon" href="public/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="https://kit.fontawesome.com/b61d0d6b73.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbarDA">
        <div class="container">
            <a class="navbar-brand logoAbbott" href="#">
                <img class="logo" src="public/img/logos/Logo_Abbott.png" alt="Logo abbott">
            </a>
        </div>
    </nav>
    <div class="container">
  <div class="row">
    <aside class="col-md-2 mt-5" style="background-color: #fdd100; border-radius:20px;">
        <ul style="list-style:none">
            <?php
            $sql2 = "SELECT nombre, estaHabilitada FROM pacientes";
            $result2 = $conn->query($sql2);

            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    echo "<li style='padding:10px 5px; color:#006747;'><input style='zoom: 1.5; margin-right:5px;' type='checkbox'";
                    if ($row2["estaHabilitada"] == 1) {
                        echo " checked";
                    }
                    echo " data-cardname='".$row2["nombre"]."' >" . ucfirst(mb_strtolower($row2["nombre"], 'UTF-8')) . "</li>";
                }
            }
            ?>
        </ul>
    </aside>
    <div class="col-md-10">
        <div class="input-group justify-content-end mt-5 mb-3">
            <div class="col-4" style="position:relative;">
                <input class="form-control" type="text" id="busqueda"><i style="position:absolute; right: 15px; bottom:10px" class="fas fa-search"></i>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Cédula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">SONIA</th>
                    <th scope="col">IAN</th>
                    <th scope="col">INGRID</th>
                    <th scope="col">SANDRA</th>
                    <th scope="col">IGNACIO</th>
                    <th scope="col">IVANNA</th>
                    <th scope="col">SANTIAGO</th>
                    <th scope="col">ISABEL</th>
                    <th scope="col">IVÁN</th>
                    <th scope="col">Última Int</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th>" . $row["Cedula"] . "</th>";
                            echo "<td>" . $row["Nombre"] . "</td>";
                            echo "<td>" . $row["SONIA"] . "</td>";
                            echo "<td>" . $row["IAN"] . "</td>";
                            echo "<td>" . $row["INGRID"] . "</td>";
                            echo "<td>" . $row["SANDRA"] . "</td>";
                            echo "<td>" . $row["IGNACIO"] . "</td>";
                            echo "<td>" . $row["IVANNA"] . "</td>";
                            echo "<td>" . $row["SANTIAGO"] . "</td>";
                            echo "<td>" . $row["ISABEL"] . "</td>";
                            echo "<td>" . $row["IVÁN"] . "</td>";
                            echo "<td>" . $row["ultima_interaccion"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No se encontraron datos</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<script>
    // Obtén todas las casillas de verificación por su nombre
    let checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Agrega un event listener a cada casilla de verificación
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Obtiene el estado actual de la casilla de verificación
            let isChecked = this.checked;

            // Obtiene el nombre del paciente desde el atributo 'data-cardname'
            let cardName = this.getAttribute('data-cardname');

            // Realiza alguna acción según el estado de la casilla de verificación
            if (isChecked) {
                // llamar a habilitar_cards.php con fetch API pasandole el cardName

                let formData = new FormData();
                formData.append('cardName', cardName);

                fetch('modelos/habilitar_cards.php', {
                    method: 'POST',
                    body: formData
                })
         
                .then(function(response) {
                    return response.text();
                })
                .then(function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Card habilitada',
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(function(error) {
                    console.log(error);
                });

                
            } else {
                console.log("El usuario desmarcó la casilla para el paciente: " + cardName);
                let formData = new FormData();
                formData.append('cardName', cardName);

                fetch('modelos/deshabilitar_cards.php', {
                    method: 'POST',
                    body: formData
                })
                .then(function(response) {
                    return response.text();
                })
                .then(function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Card deshabilitada',
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(function(error) {
                    console.log(error);
                });
                
            }
        });
    });

    // Obtener referencia al campo de búsqueda
    let input = document.getElementById('busqueda');

    // Agregar evento de escucha al campo de búsqueda
    input.addEventListener('input', function() {
        // Obtener el valor actual del campo de búsqueda
        let searchText = input.value.toLowerCase();

        // Obtener todas las filas de la tabla
        let rows = document.querySelectorAll('tbody tr');

        // Iterar sobre cada fila y ocultar o mostrar según coincida con el texto de búsqueda
        rows.forEach(function(row) {
            let cedula = row.querySelector('th').textContent.toLowerCase();
            let nombre = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            
            if (cedula.includes(searchText) || nombre.includes(searchText)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>


</body>
</html>



