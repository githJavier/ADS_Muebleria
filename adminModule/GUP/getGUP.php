<?php
function validaBoton($boton) {
    return isset($boton);
}

function mostrarMensaje($mensaje) {
    include 'ScreenMensaje.php';
    $objMensaje = new ScreenMensaje();
    $objMensaje->screenMensajeShow($mensaje, "getGUP.php");
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
    return strlen($clave) >= 3;
}

function validarIdUsuario($id) {
    // Verifica que esté definido y sea un número entero
    if (isset($id) && ctype_digit($id) && (int)$id > 0) {
        return true;
    }
    return false;
}


// Capturar botones
$btnGUP = $_POST['btnGUP'] ?? null;
$btnAgregarUsuario = $_POST['btnAgregarUsuario'] ?? null;
$btnCrearUsuario = $_POST['btnCrearUsuario'] ?? null;
$btnEditarUsuario = $_POST['btnEditarUsuario'] ?? null;
$btnActualizarUsuario = $_POST['btnActualizarUsuario'] ?? null;
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

    if (validarNombre($nombre)) {
        if (validarNombre($apellido)) {
            if (validarCorreo($correo)) {
                if (validarTelefono($telefono)) {
                    if (validarClave($clave)) {
                        include 'controlGUP.php';
                        $objControlGUP = new ControlGUP();
                        $objControlGUP->crearUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad, $roles, $privilegios);
                    } else {
                        mostrarMensaje("La contraseña debe tener al menos 5 caracteres.");
                    }
                } else {
                    mostrarMensaje("El teléfono debe tener 9 dígitos.");
                }
            } else {
                mostrarMensaje("El correo electrónico no es válido.");
            }
        } else {
            mostrarMensaje("El apellido no es válido.");
        }
    } else {
        mostrarMensaje("El nombre no es válido.");
    }
} else if (validaBoton($btnEditarUsuario)) {
    $idUsuario = $_POST['idUsuario'] ?? null;

    if ($idUsuario) {
        include 'controlGUP.php';
        $objControlGUP = new ControlGUP();
        $objControlGUP->mostrarFormularioEditarUsuario($idUsuario);
    } else {
        mostrarMensaje("Error: No se proporcionó un ID de usuario válido.");
    }
} else if (validaBoton($btnActualizarUsuario)) {
    // Capturar los datos del formulario
    $idUsuario = $_POST['idUsuario'];
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

    // Validar los datos
    if (validarNombre($nombre) && validarNombre($apellido)) {
        if (validarCorreo($correo)) {
            if (validarTelefono($telefono)) {
                if (empty($clave) || validarClave($clave)) {
                    include 'controlGUP.php';
                    $objControlGUP = new ControlGUP();
                    $objControlGUP->actualizarUsuario($idUsuario, $nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad, $roles, $privilegios);
                } else {
                    mostrarMensaje("La contraseña debe tener al menos 5 caracteres.");
                }
            } else {
                mostrarMensaje("El teléfono debe tener 9 dígitos.");
            }
        } else {
            mostrarMensaje("El correo electrónico no es válido.");
        }
    } else {
        // mostrarMensaje("El nombre o apellido estan vacios");
        // mostrarMensaje("El nombre o apellido es muy corto");
        mostrarMensaje("El nombre o apellido no es válido.");
    }
} else if (validaBoton($btnEliminarUsuario)) {

    //
    $idUsuario = $_POST['idUsuario'] ?? null;

    if (validarIdUsuario($idUsuario)) {
        include 'controlGUP.php';
        $objControlGUP = new ControlGUP();
        $objControlGUP->eliminarUsuario($idUsuario);
    } else {
        mostrarMensaje("Error: No se proporcionó un ID de usuario válido para eliminar.");
    }
} else {
    mostrarMensaje("Acceso denegado. No se detectó un intento válido.");
}
