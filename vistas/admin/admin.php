<?php
require_once '../comunes/header.php';
?>

<form class="formadmin">
  <div class="mb-3">
    <label for="usuario" class="form-label">Usuario</label>
    <input type="text" name="usuario" class="form-control" id="usuario">
  </div>
  <div class="mb-3">
    <label for="contraseña" class="form-label">Contraseña</label>
    <input type="contraseña" name="contraseña" class="form-control" id="contraseña">
  </div>
  <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
</form>


<script>
    document.querySelector('.formadmin').addEventListener('submit', iniciarSesion);

    function iniciarSesion(e) {
        e.preventDefault();

        const usuario = document.querySelector('#usuario').value;
        const contraseña = document.querySelector('#contraseña').value;

        if (usuario === '' || contraseña === '') {
            // El usuario o la contraseña están vacíos
            mostrarNotificacion('Todos los campos son obligatorios', 'error');
            return;
        }

        const datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('contraseña', contraseña);
        datos.append('accion', 'iniciar_sesion');

        fetch('modelos/validar_admin.php', {
        method: 'POST',
        body: datos
        })
        .then(response => {
            if (response.ok) {
            return response.text();
            } else {
            throw new Error('Error en la solicitud');
            }
        })
        .then(respuesta => {
            console.log(respuesta);

            if (respuesta === 'existe') {
            // El usuario existe
            window.location.href = 'dashboard';
            } else if (respuesta === 'usuario_incorrecto') {
            // El usuario no existe
            mostrarNotificacion('El usuario no existe', 'error');
            } else if (respuesta === 'contraseña_incorrecta') {
            // La contraseña es incorrecta
            mostrarNotificacion('La contraseña es incorrecta', 'error');
            }
        })
        .catch(error => {
            console.error(error);
        });
    }

    // Mostrar notificación
    function mostrarNotificacion(mensaje, clase) {
        const notificacion = document.createElement('div');
        notificacion.classList.add(clase, 'notificacion', 'sombra');
        notificacion.textContent = mensaje;

        // Formulario
        const formulario = document.querySelector('.formadmin');
        formulario.insertBefore(notificacion, document.querySelector('form legend'));

        // Ocultar y mostrar la notificación
        setTimeout(() => {
            notificacion.classList.add('visible');

            setTimeout(() => {
                notificacion.classList.remove('visible');

                setTimeout(() => {
                    notificacion.remove();
                }, 500);
            }, 3000);
        }, 100);
    }


</script>


<?php
require_once '../comunes/footer.php';
?>