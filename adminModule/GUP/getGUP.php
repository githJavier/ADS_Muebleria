<?php
function validaBoton($boton) {
    return isset($boton);
}

function mostrarMensaje($mensaje) {
    include '../../shared/mensajeSistema.php';
    $objMensaje = new mensajeSistema();
    $objMensaje->mensajeSistemaShow($mensaje, "getGUP.php");
}

// Funciones de validación para cada campo
function validarNombre($nombre) {
    return !empty($nombre) && preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/", $nombre);
}

function validarCorreo($correo) {
    return filter_var($correo, FILTER_VALIDATE_EMAIL);
}

function validarTelefono($telefono) {
    return preg_match("/^\d{9}$/", $telefono);
}

function validarClave($clave) {
    return strlen($clave) >= 5;
}

// Capturar botones
$btnGUP = $_POST['btnGUP'] ?? null;
$btnAgregarUsuario = $_POST['btnAgregarUsuario'] ?? null;
$btnCrearUsuario = $_POST['btnCrearUsuario'] ?? null;
$btnEditarUsuario = $_POST['btnEditarUsuario'] ?? null;
$btnEliminarUsuario = $_POST['btnEliminarUsuario'] ?? null;

if (validaBoton($btnGUP)) {
    include 'controlGUP.php';
    $objControlGUP = new ControlGUP();
    $objControlGUP->obtenerListaGUP();
} else if (validaBoton($btnAgregarUsuario)) {
    include 'controlGUP.php';
    $objControlGUP = new ControlGUP();
    $objControlGUP->mostrarFormularioAgregarUsuario();
} else if (validaBoton($btnCrearUsuario)) {
    // Validar los datos del formulario
    $nombre = $_POST['txtNombre'];
    $apellido = $_POST['txtApellido'];
    $correo = $_POST['txtCorreo'];
    $telefono = $_POST['txtTelefono'];
    $nombreUsuario = $_POST['txtUsuario'];
    $clave = $_POST['txtClave'];
    $estado = $_POST['checkEstado'] ?? null;
    $preguntaSeguridad = $_POST['textPregunta'];
    $respuestaSeguridad = $_POST['textRespuesta'];
    $roles = $_POST['roles'] ?? [];
    $privilegios = $_POST['privilegios'] ?? [];

    if (!validarNombre($nombre) || !validarNombre($apellido)) {
        mostrarMensaje("El nombre o apellido no es válido.");
    } else if (!validarCorreo($correo)) {
        mostrarMensaje("El correo electrónico no es válido.");
    } else if (!validarTelefono($telefono)) {
        mostrarMensaje("El teléfono debe tener 9 dígitos.");
    } else if (!validarClave($clave)) {
        mostrarMensaje("La contraseña debe tener al menos 5 caracteres.");
    } else {        
        include 'controlGUP.php';
        $objControlGUP = new ControlGUP();
        // ✅
        $objControlGUP->crearUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad, $roles, $privilegios);
    }


    // if (!validarNombre($nombre) || !validarNombre($apellido)) {
    //     if (!validarCorreo($correo)) {
    //         if (!validarTelefono($telefono)) {
    //             if (!validarClave($clave)) {

    //                 include 'controlGUP.php';
    //                 $objControlGUP = new ControlGUP();
    //                 $objControlGUP->crearUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad, $roles, $privilegios);
    //             } else {
    //                 mostrarMensaje("La contraseña debe tener al menos 5 caracteres.");
    //             }
    //         } else {
    //             mostrarMensaje("El teléfono debe tener 9 dígitos.");
    //         }
    //     } else {
    //         mostrarMensaje("El correo electrónico no es válido.");
    //     }
    // } else {
    //     mostrarMensaje("El nombre o apellido no es válido.");
    // }

} else if (validaBoton($btnEditarUsuario)) {
    mostrarMensaje("Función de editar usuario aún no implementada.");
} else if (validaBoton($btnEliminarUsuario)) {
    mostrarMensaje("Función de eliminar usuario aún no implementada.");
} else {
    mostrarMensaje("Acceso denegado. No se detectó un intento válido.");
}
?>
