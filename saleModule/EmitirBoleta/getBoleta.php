<?php 
include_once("./controlEmitirBoleta.php");
include_once("./formEmitirBoleta.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");
session_start();

function validaBoton($boton) {
    return isset($boton);
}

function verificarSesionIniciada() {
    return isset($_SESSION['usuario']);
}

function verificarCamposVacios($txtBuscarProducto) {
    return ($txtBuscarProducto != "");
}
function verificarCaracteresEspeciales($txtBuscarProducto) {
    // Verifica si el texto contiene solo números
    if (preg_match("/[^0-9]/", $txtBuscarProducto)) {
        return true; // Contiene caracteres no numéricos
    } else {
        return false; // Solo contiene números
    }
}
function mostrarMensaje($mensaje){
    $objMensaje = new MensajeVulnerabilidadSistema();
    $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
}

//Declaracion de Botones
$btnEmitirBoleta = $_POST['btnEmitirBoleta'] ?? null;
$btnBuscarProforma = $_POST['btnBuscarProforma'] ?? null;
$txtCodigoProforma = $_POST['txtCodigoProforma'] ?? null;

if(validaBoton($btnEmitirBoleta)){
    if (verificarSesionIniciada()) {
        $objControlEmitirBoleta = new controlEmitirBoleta();
        $objControlEmitirBoleta->listarProformas();
    }else {
        mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
    }
}else if(validaBoton($btnBuscarProforma)){
    if(verificarCamposVacios($txtCodigoProforma)){
        if(!verificarCaracteresEspeciales($txtCodigoProforma)){
            $objControlEmitirBoleta = new controlEmitirBoleta();
            $objControlEmitirBoleta->listarBusquedaProformas($txtCodigoProforma);
        }else {
            $objProducto = new proforma();
            $listaProforma = $objProducto->listarProformas();
            $objFormEmitirBoleta = new formEmitirBoleta();
            $objFormEmitirBoleta->formEmitirBoletaShow($listaProforma);

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "getBoleta.php");
        }
    }else {
        $objProducto = new proforma();
        $listaProforma = $objProducto->listarProformas();
        $objFormEmitirBoleta = new formEmitirBoleta();
        $objFormEmitirBoleta->formEmitirBoletaShow($listaProductos);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese codigo válido", "getProforma.php");
    }
}else {
    mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
}