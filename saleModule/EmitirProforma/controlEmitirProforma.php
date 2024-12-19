<?php
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
        $subtotalProforma = $totalProforma * 0.82;  // Correcto cálculo del subtotal
        $impuesto = floatval($totalProforma * 0.18);  // Cálculo del impuesto
        
        // Insertar proforma en la base de datos
        $objProforma = new proforma();
        $idProforma = $objProforma->insertarProforma($numeroProforma, $Usuario, $fecha, $hora, $totalProforma, $subtotalProforma, $impuesto);

        if ($idProforma) {
            // Insertar detalles de la proforma
            $objDetalleProforma = new detalle_proforma();
            foreach ($listaProductos as $listaProducto) {
                $idProducto = $listaProducto["idProducto"];
                $cantidad = $listaProducto["cantidad"];
                $subtotal = $listaProducto["subtotal"];
                $precioTotalProducto = $cantidad * $subtotal;
                $respuesta = $objDetalleProforma->registrarDetalleProforma($idProforma, $idProducto, $cantidad, $subtotal, $precioTotalProducto);
                
                if (!$respuesta) {
                    // Si falla la inserción de un detalle, mostrar mensaje y salir
                    $objMensajeSistema->mensajeSistemaShow("Error al insertar detalles de la proforma", "../../securityModule/panelPrincipalUsuario.php", "systemOut");
                    return;
                }
            }

            // Si todo es correcto, mostrar mensaje de éxito
            $objMensajeSistema->mensajeSistemaShow("Proforma generada con éxito", "../EmitirProforma/getProforma.php", "systemOut", true);
        } else {
            // Si falla la inserción de la proforma, mostrar mensaje de error
            $objMensajeSistema->mensajeSistemaShow("Error al generar la proforma", "../../securityModule/panelPrincipalUsuario.php", "systemOut");
        }
    }
}
?>
