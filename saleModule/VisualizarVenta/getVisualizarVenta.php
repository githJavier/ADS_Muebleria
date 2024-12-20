<?php 
session_start();
include_once("controlVisualizarVenta.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");

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
    if (preg_match("/[^a-zA-Z0-9áéíóúÁÉÍÓÚ\s]/", $txtBuscarProducto)) {
        return true;
    } else {
        return false;
    }
}
function mostrarMensaje($mensaje){
    $objMensaje = new MensajeVulnerabilidadSistema();
    $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
}
// Declaración de Botones
$btnVisualizarVenta = $_POST['btnVisualizarVenta'] ?? null;
$btnBuscarBoleta = $_POST['btnBuscarBoleta'] ?? null;
$btnDetalleBoleta = $_POST['btnDetalleBoleta'] ?? null;
$btnDespacharBoleta = $_POST['btnDespacharBoleta'] ?? null;


if (validaBoton($btnVisualizarVenta)) {
    $objControlVisualizarVenta = new formVisualizarVenta;
    $objControlVisualizarVenta->formVisualizarVentaShow(null);
}else if(validaBoton($btnBuscarBoleta)){
    $txtNumeroBoleta = $_POST['txtCodigoBoleta'];
    if (verificarCamposVacios($txtNumeroBoleta)) {
        if (!verificarCaracteresEspeciales($txtNumeroBoleta)) {
            $objControlVisualizarVenta = new controlVisualizarVenta;
            $objControlVisualizarVenta->listaBusquedaBoleta($txtNumeroBoleta);

        }else{
            $objControlVisualizarVenta = new formVisualizarVenta;
            $objControlVisualizarVenta->formVisualizarVentaShow(null);
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "getProforma.php");
            
        }
    }else{
        $objControlVisualizarVenta = new formVisualizarVenta;
        $objControlVisualizarVenta->formVisualizarVentaShow(null);
        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese id o nombre de producto válido", "getProforma.php");
        
    }
}else if(validaBoton($btnDetalleBoleta)){
    $idBoleta = $_POST['txtIdBoleta'] ?? null;  
    $objControlVisualizarVenta = new controlVisualizarVenta;
    $objControlVisualizarVenta->obtenerDatosDetalleBoleta($idBoleta);
}else if(validaBoton($btnDespacharBoleta)){
    $idBoleta = $_POST['txtIdBoletaEstado'] ?? null;
    $objControlVisualizarVenta = new controlVisualizarVenta;
    $objControlVisualizarVenta->actualizarEstadoBoleta($idBoleta);
}
else{
    mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
    exit;
}

?>