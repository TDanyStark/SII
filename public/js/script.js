
document.getElementById("iniciarSesionBtn").addEventListener("click", function() {
    var cedula = document.getElementById("cedula").value;
    var nombre = document.getElementById("nombre").value;

    // Validar que el campo de cédula no esté vacío
    if (cedula === "") {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes ingresar tu cédula',
        })
        return;
    }

    // Realizar una solicitud al archivo PHP utilizando Fetch
    fetch("modelos/validar_usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "cedula=" + encodeURIComponent(cedula) + "&nombre=" + encodeURIComponent(nombre)
    })
    .then(function(response) {
        return response.text();
    })
    .then(function(data) {
        if (data === "existe" || data === "registro_exitoso") {
            // Si el usuario existe en la base de datos, redirigir a sistema.php
            window.location.href = "sistema";
        } else{
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'No se ha encontrado la cédula ingresada, si ya te habias registrado, por favor recarga la pagina.',
            })

            document.getElementById("iniciarSesionBtn").textContent = "Registrarse";
            // Si el usuario no existe, mostrar el campo de nombre y registrar los datos en la base de datos
            document.getElementById("nombre").classList.remove("d-none");
            document.getElementById("labelnombre").classList.remove("d-none");
            // Aquí puedes realizar la lógica para manejar la respuesta
            console.log(data);
        }
    })
    .catch(function(error) {
        // Manejar cualquier error de la solicitud
        console.error(error);
    });
});