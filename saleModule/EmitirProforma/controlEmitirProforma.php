<?php
// Verifica si la sesión ya está iniciada, solo la inicia si no lo está.


include_once("./formEmitirProforma.php");
include_once("../../model/producto.php");
include_once("../../model/categoria.php");
include_once("../../model/proforma.php");
include_once("../../model/detalle_proforma.php");

class controlEmitirProforma {
    public function listarProductosBD() {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos);
    }
    
    

    public function listarBusquedaProductos($txtBuscarProducto) {
        $objProducto = new producto();
        $listaProductos = $objProducto->obtenerProductosBusqueda($txtBuscarProducto);
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos);
    }

    public function emitirProforma($listaProductos, $totalProforma ,$usuario) {
        // Verifica si la sesión está activa antes de intentar acceder a las variables de sesión.
        if (isset($usuario)) {
            $Usuario = $usuario;
        } else {
            // Redirigir a login si no se encuentra el usuario en la sesión
            header('Location: login.php');
            exit();
        }

        $objMensajeSistema = new mensajeSistema();
        date_default_timezone_set('America/Lima');
        // Obtener el año y el mes actuales
        $year = date("Y");   // Año actual
        $month = date("m");   // Mes actual
        $numeroProforma = new proforma;
        $numeroProforma = $numeroProforma->generarNumeroProforma($year, $month);
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $subtotalProforma = $totalProforma *0.72;
        $impuesto = floatval($totalProforma * 0.18);
        $objProforma = new proforma();
        $idProforma = $objProforma->insertarProforma($numeroProforma, $Usuario, $fecha, $hora, $totalProforma,$subtotalProforma, $impuesto);

        $objDetalleProforma = new detalle_proforma();
        foreach ($listaProductos as $listaProducto) {
            $idProducto = $listaProducto["idProducto"];
            $cantidad = $listaProducto["cantidad"];
            $subtotal = $listaProducto["subtotal"];
            $precioTotalProducto = $cantidad * $subtotal;
            $respuesta = $objDetalleProforma->registrarDetalleProforma($idProforma, $idProducto, $cantidad, $subtotal,$precioTotalProducto);
        }

        if ($respuesta) {
            $objMensajeSistema->mensajeSistemaShow("Proforma generada con éxito", "../../securityModule/panelPrincipalUsuario.php", "systemOut", true);
        } else {
            $objMensajeSistema->mensajeSistemaShow("Oops! Parece que algo salió mal.", "../../securityModule/panelPrincipalUsuario.php", "systemOut");
        }
    }
}
?>
