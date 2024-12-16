<?php 
include_once("controlAutenticarUsuario.php");
function validaBoton($boton) {
    return isset($boton);
}

function validaTexto($txtUsuario, $txtClave) {
    return strlen(trim($txtUsuario)) > 3 && strlen($txtClave) > 3;
}
function mostrarMensaje($mensaje){
    $objMensaje = new MensajeVulnerabilidadSistema();
    $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
}
//Declaracion de botones
$btnIngresar = $_POST['btnIngresar'] ?? null;

if(validaBoton($btnIngresar)){
    $usuario = trim(strtolower($_POST['txtUsuario']));
    $clave = $_POST['txtClave'];
    if(validaTexto($usuario,$clave)){
        include_once("controlAutenticarUsuario.php");
        $objControl = new controlAutenticarUsuario();
        $objControl->verificarUsuario($usuario, $clave);
    }else{
        mostrarMensaje("Los datos ingresados no son válidos.");
    }
}else{
    mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
}


?>
