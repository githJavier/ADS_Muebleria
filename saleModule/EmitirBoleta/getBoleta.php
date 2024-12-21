<?php 
include_once("./controlEmitirBoleta.php");
include_once("./formEmitirBoleta.php");
include_once("./formEmitirBoletaVenta.php");
include_once("./formVerBoleta.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");
include_once("../../model/producto.php");
session_start();

function validaBoton($boton) {
    return isset($boton);
}

function verificarSesionIniciada() {
    return isset($_SESSION['usuario']);
}

function verificarCamposVacios($txtBuscarProducto) {
    if ($txtBuscarProducto != "") {
        if (strlen($txtBuscarProducto) == 11 && strlen($txtBuscarProducto)>0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function verificarExistenciaProductos($idProductos) {
    if (is_array($idProductos)) {
        foreach ($idProductos as $idProducto) {
            if (empty($idProducto)) {
                return false;
            }
        }
        return true;
    }
    return !empty($idProductos);
}
function verificarCantidadesIngresadas($cantidades) {
    if (is_array($cantidades)) {
        foreach ($cantidades as $cantidad) {
            if (!empty($cantidad) && $cantidad > 0) {
                return true;
            }
        }
        return false;
    }
    return false;
}
function validarStockBD($idProductos, $cantidades) {
    if (count($idProductos) !== count($cantidades)) {
        return false; 
    }
    foreach ($idProductos as $index => $idProducto) {
        $objValidaStock = new producto;
        $stock = $objValidaStock->validadStockBD($idProducto);
        $cantidad = $cantidades[$index];
        if ($stock < $cantidad) { 
            return false;
        }
    }
    return true;
}



function verificarCaracteresEspeciales($txtBuscarProducto) {
    if (preg_match("/[^0-9]/", $txtBuscarProducto)) {
        return true;
    } else {
        return false;
    }
}

function mostrarMensaje($mensaje){
    $objMensaje = new MensajeVulnerabilidadSistema();
    $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
}
function validarCheckBox($checkBox){
    return isset($checkBox);
}

//Declaracion de Botones
$btnEmitirBoleta = $_POST['btnEmitirBoleta'] ?? null;
$btnBuscarProforma = $_POST['btnBuscarProforma'] ?? null;
$txtCodigoProforma = $_POST['txtCodigoProforma'] ?? null;
$btnVerBoleta = $_POST['btnVerBoleta'] ?? null;
$idProforma = $_POST['txtIdProforma'] ?? null;
$btnCancelar = $_POST['btnCancelar'] ?? null;
$btnProcesarPago = $_POST['btnProcesarPago'] ?? null;
$checkBoxPago = $_POST['checkBoxPago'] ?? null;
//captura
$idProducto = $_POST['idProducto'] ?? null;
$cantidades = $_POST['cantidades'] ?? null;
$preciosUnitarios = $_POST['preciosUnitarios'] ?? null;
$totalBoleta = $_POST['totalProforma'] ?? null;



if(validaBoton($btnEmitirBoleta) || validaBoton($btnCancelar)){
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
            $objControlEmitirBoleta = new controlEmitirBoleta();
            $objControlEmitirBoleta->listarProformas();

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "getBoleta.php");
        }
    }else {
        $objControlEmitirBoleta = new controlEmitirBoleta();
        $objControlEmitirBoleta->listarProformas();

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese numero de proforma válido", "getProforma.php");
    }
}else if(validaBoton($btnVerBoleta)){
    $objControlEmitirBoletaVenta = new ControlEmitirBoleta();
    $objControlEmitirBoletaVenta->verDetalleProforma($idProforma);

}else if(validaBoton($btnProcesarPago)){
    if (validarCheckBox($checkBoxPago) && ($checkBoxPago === 'efectivo' || $checkBoxPago === 'tarjeta')) {
        if(verificarExistenciaProductos($idProducto)){
            if(verificarCantidadesIngresadas($cantidades)){
                if(validarStockBD($idProducto, $cantidades)){
                    // Inicializar el array listaProductos
                    $listaProductos = [];
                    // Recorrer los datos y combinarlos
                    foreach ($idProducto as $index => $id) {
                        $listaProductos[] = [
                            'idProducto' => $id,
                            'cantidad' => $cantidades[$index] ?? 0,
                            'precioUnitario' => $preciosUnitarios[$index] ?? 0.0,
                        ];
                    }
                    $tipoPago = 0; 
                    if($checkBoxPago === 'efectivo'){
                        $tipoPago = 1;
                    }else if($checkBoxPago === 'tarjeta'){
                        $tipoPago = 2;
                    }
                    $objControlEmitirBoleta = new ControlEmitirBoleta;
                    $idBoleta = $objControlEmitirBoleta->emitirBoleta($listaProductos, $totalBoleta, $_SESSION['usuario'], $tipoPago);
                    $respuesta = $objControlEmitirBoleta->actualizarStock($listaProductos);
                    $objControlEmitirBoleta->actualizarEstado($idProforma);
                    $objControlEmitirBoleta->listaDetalleBoleta($idBoleta);

                    
                }else{
                    $objControlEmitirBoleta = new controlEmitirBoleta();
                    $objControlEmitirBoleta->listarProformas();
                    $objMensajeSistema = new mensajeSistema();
                    $objMensajeSistema->mensajeSistemaShow("Stock no disponible.", "getBoleta.php");
                } 
            }else{
                $objControlEmitirBoleta = new controlEmitirBoleta();
                $objControlEmitirBoleta->listarProformas();
                $objMensajeSistema = new mensajeSistema();
                $objMensajeSistema->mensajeSistemaShow("La cantidad de cada producto debe ser mayor a 0.", "getBoleta.php");
            }

        }else{
            $objControlEmitirBoleta = new controlEmitirBoleta();
            $objControlEmitirBoleta->listarProformas();
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Lista de productos vacía.", "getBoleta.php");
        }
        
    }else{
        $objControlEmitirBoleta = new controlEmitirBoleta();
        $objControlEmitirBoleta->listarProformas();

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Seleccione un método de pago.", "getBoleta.php");
    }
}else {
    mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
}