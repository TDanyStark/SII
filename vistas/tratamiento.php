<?php 

require_once '../modelos/db.php';

session_start();

$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];

if (!isset($cedula)) {
    // El usuario no ha iniciado sesión
    header('Location: home');
}

$id = $_GET['id'];

if (!isset($id)) {
    // El usuario no ha iniciado sesión
    header('Location: home');
}

// Verificar si la conexión fue exitosa
if (!$conn) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

$query = "SELECT * FROM pacientes WHERE ID = '$id'";
$resultado = mysqli_query($conn, $query);
$paciente = mysqli_fetch_assoc($resultado);

$idPaciente = $paciente['ID'];
$nombrePaciente = $paciente['nombre'];
$edadPaciente = $paciente['edad'];
$card = $paciente['card'];
$medicamentoCorrecto = $paciente['medicamentocorrecto'];


require_once 'comunes/header.php';
?>

<div class="eleccion">
    <h1>ELECCIÓN DEL TRATAMIENTO</h1>
</div>

<div class="row" style="background-color: #00b040; margin: 0;">
    <div class="col-4 border-white">
        <div class="card-content">
            <img src="public/img/medicamentos/RIFAX.png" alt="RIFAX" class="resized-image">
            <img src="public/img/medicamentos/MAS.png" alt="MAS" class="resized-image">
            <img src="public/img/medicamentos/DICETEL_DUO.png" alt="DICETEL_DUO" class="resized-image">
            <img src="public/img/medicamentos/MAS.png" alt="MAS" class="resized-image">
            <img src="public/img/medicamentos/LGG.png" alt="LGG" class="resized-image">
        </div>
        <div class="card-button">
            <button type="button" data-option="tratamiento1" class="ver_aqui btn-veraqui">VER AQUÍ</button>
        </div>
    </div>
    <div class="col-4 border-white">
        <div class="card-content">
            <img src="public/img/medicamentos/DUSPATALIN.png" alt="DUSPATALIN" class="resized-image">
            <img src="public/img/medicamentos/MAS.png" alt="MAS" class="resized-image">
            <img src="public/img/medicamentos/BIOLAX.png" alt="BIOLAX" class="resized-image">
        </div>
        <div class="card-button">
            <button type="button" data-option="tratamiento2" class="ver_aqui btn-veraqui">VER AQUÍ</button>
        </div>
    </div>
    <div class="col-4 border-white">
        <div class="card-content">
            <img src="public/img/medicamentos/EUMOTRIX.png" alt="EUMOTRIX" class="resized-image">
        </div>
        <div class="card-button">
            <button type="button" data-option="tratamiento3" class="ver_aqui btn-veraqui">VER AQUÍ</button>
        </div>
    </div>
</div>

<input type="hidden" data-correct="<?php echo $medicamentoCorrecto?>">
<input type="hidden" data-cardname="<?php echo $nombrePaciente?>">

<!-- prueba XD -->

<?php
$query2 = "SELECT * FROM cards_paciente WHERE id_paciente = '$id'";
$resultado2 = mysqli_query($conn, $query2);

if (mysqli_num_rows($resultado2) > 0) {
    // Mostrar los casos clínicos
    while ($row = mysqli_fetch_assoc($resultado2)) {
        $html1 = $row['HTML1'];
        $html2 = $row['HTML2'];
        $html3 = $row['HTML3'];
        $medidor1 = $row['color_medidor1'];
        $medidor2 = $row['color_medidor2'];
        $medidor3 = $row['color_medidor3'];
?>
<div class="contenedor-body d-none" id="tratamiento1">
    <div class="btn-cerrar">
        <button type="button" class="btn btn-dark btn-cerrar"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="contenedor-card">
        <h1 class="muy-bien"></h1>
        <div class="card-content-2">
            <img src="public/img/medicamentos/RIFAX.png" alt="RIFAX" >
            <img src="public/img/medicamentos/MAS.png" alt="MAS" class="plus">
            <img src="public/img/medicamentos/DICETEL_DUO.png" alt="DICETEL_DUO" >
            <img src="public/img/medicamentos/MAS.png" alt="MAS" class="plus">
            <img src="public/img/medicamentos/LGG.png" alt="LGG" >
        </div>
        <div class="imagen-medidor">
            <img src="public/img/medidores/<?php echo $medidor1;?>.png" alt="medidor" class="medidor">
        </div>
        <div class="texto-card">
            <?php echo $html1?>
        </div>
    </div>
</div>

<div class="contenedor-body d-none" id="tratamiento2">
    <div class="btn-cerrar">
        <button type="button" class="btn btn-dark btn-cerrar"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="contenedor-card">
        <h1 class="muy-bien"></h1>
        <div class="card-content-2">
            <img src="public/img/medicamentos/DUSPATALIN.png" alt="DUSPATALIN">
            <img src="public/img/medicamentos/MAS.png" alt="MAS" class="plus">
            <img src="public/img/medicamentos/BIOLAX.png" alt="BIOLAX">
        </div>
        <div class="imagen-medidor">
            <img src="public/img/medidores/<?php echo $medidor2;?>.png" alt="medidor" class="medidor">
        </div>
        <div class="texto-card">
        <?php echo $html2?>
        </div>
    </div>
</div>

<div class="contenedor-body d-none" id="tratamiento3">
    <div class="btn-cerrar">
        <button type="button" class="btn btn-dark btn-cerrar"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="contenedor-card">
        <h1 class="muy-bien"></h1>
        <div class="card-content-2">
            <img src="public/img/medicamentos/EUMOTRIX.png" alt="EUMOTRIX">
        </div>
        <div class="imagen-medidor">
            <img src="public/img/medidores/<?php echo $medidor3;?>.png" alt="medidor" class="medidor">
        </div>
        <div class="texto-card">
            <?php echo $html3?>
        </div>
    </div>
</div>

<?php
    }
} else {
    // No se encontraron casos clínicos
    echo "<div class='col-md-12'>";
    echo "<h2>No se encontraron casos clínicos</h2>";
    echo "</div>";
}
?>

<script>
    let cardtratamiento = "";
    let correct = document.querySelector('[data-correct]').getAttribute('data-correct');
    let $nombrePaciente = document.querySelector('[data-cardname]').getAttribute('data-cardname');

    document.addEventListener('click', function (e) {

        if(e.target.getAttribute('data-option')){
            let btnClick = e.target.getAttribute('data-option');

            // actualizar la interaccion de la base de datos usando fetch a modelos/sumar_interaccion.php
            let cedula = "<?php echo $cedula?>";

            let data = new FormData();
            data.append('cedula', cedula);
            data.append('nombre', $nombrePaciente);

            fetch('modelos/sumar_interaccion.php', {
                method: 'POST',
                body: data
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (text) {
                console.log(text);
            })
            .catch(function (error) {
                console.error(error);
            });
            

            cardtratamiento = document.getElementById(btnClick);

            console.log(btnClick, correct);

            if (btnClick == correct) {
                cardtratamiento.querySelector('.muy-bien').textContent = "¡MUY BIEN!";
            } else{
                cardtratamiento.querySelector('.muy-bien').textContent = "¡INTÉNTALO DE NUEVO!";
            }
            cardtratamiento.classList.remove('d-none');
            document.body.classList.add('no-scroll');
        }


        if (e.target.closest('.btn-cerrar')) {
            cardtratamiento.classList.add('d-none');
            document.body.classList.remove('no-scroll');
        }

    });
</script>

<?php 
include_once 'comunes/footer.php';
?>