<?php
include_once("controlRecordarClave.php");
include_once("ScreenMensaje.php");

// Función para validar si el botón fue presionado
function validaBoton($boton) {
    return isset($boton);
}

// Función para validar el nombre de usuario
function validarNombreUsuario($usuario) {
    return strlen(trim($usuario)) > 3;
}

// Función para mostrar mensajes de error
function mostrarMensaje($mensaje) {
    $objMensaje = new ScreenMensaje();
    $objMensaje->screenMensajeShow($mensaje, "../../viewRecordarClave.php");
}

// Capturar el botón del formulario
$btnVerificarUsuario = $_POST['btnVerificarUsuario'] ?? null;
echo("<pre>");
var_dump($_POST);
echo("</pre>");
exit;

if (validaBoton($btnVerificarUsuario)) {
    $usuario = trim(strtolower($_POST['txtUsuario']));
    
    if (validarNombreUsuario($usuario)) {
        // Llamar al controlador para verificar el usuario
        $objControl = new ControlRecordarClave();
        $objControl->mostrarFormPregunta($usuario);
    } else {
        mostrarMensaje("El nombre de usuario no es válido. Debe tener al menos 4 caracteres.");
    }
} else {
    mostrarMensaje("Acceso denegado. Se detectó un intento de acceso no autorizado.");
}
?>
