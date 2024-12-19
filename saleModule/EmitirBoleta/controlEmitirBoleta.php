<?php 
include_once("../../model/proforma.php");
include_once("../../model/boleta.php");
include_once("../../model/detalle_boleta.php");
include_once("./formEmitirBoleta.php");
include_once("./formEmitirBoletaVenta.php");
include_once("./formVerBoleta.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../model/producto.php");
    class ControlEmitirBoleta{
        public function listarProformas() {
            $objproforma = new Proforma();
            $listaProductos = $objproforma->listarProformas();
            $objFormEmitirProforma = new formEmitirBoleta();
            $objFormEmitirProforma->formEmitirBoletaShow($listaProductos);
        }
        public function listarBusquedaProformas($txtBuscarProforma) {
            $objProducto = new proforma();
            $listaProformas = $objProducto->obtenerProformasBusqueda($txtBuscarProforma);
            $objFormEmitirProforma = new formEmitirBoleta();
            $objFormEmitirProforma->formEmitirBoletaShow($listaProformas);
        }
        public function verDetalleProforma($idProforma){
            $objproforma = new proforma;
            $listaDetalleProforma = $objproforma->obtenerDetalleProforma($idProforma);
            $objFormEmitirBoletaVenta = new formEmitirBoletaVenta();
            $objFormEmitirBoletaVenta->formEmitirBoletaVentaShow($listaDetalleProforma);
            
        }
        public function emitirBoleta($listaProductos, $totalBoleta ,$usuario, $tipoPago) {
            //Obtener año y mesa
            date_default_timezone_set('America/Lima');
            $año = date("Y");
            $mes = date("m");   
            $numeroBoleta = new boleta;
            $numeroBoleta = $numeroBoleta->generarNumeroBoleta($año,$mes);
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
            $impuestoBoleta = floatval($totalBoleta*0.18);
            $subTotalBoleta = floatval($totalBoleta*0.82);

            $objBoleta = new boleta;
            $idBoleta = $objBoleta->insertarBoleta($numeroBoleta, $fecha,$hora, $usuario,$impuestoBoleta,$subTotalBoleta,$totalBoleta,$tipoPago);
            if ($idBoleta) {
                // Insertar detalles de la proforma
                $objDetalleBoleta = new detalle_boleta;
                foreach ($listaProductos as $listaProducto) {
                    $idProducto = $listaProducto["idProducto"];
                    $cantidad = $listaProducto["cantidad"];
                    $precioUnitario = $listaProducto["precioUnitario"];
                    $precioTotalProducto = $cantidad * $precioUnitario;
                    $objDetalleBoleta->registrarDetalleBoleta($cantidad, $precioUnitario, $precioTotalProducto, $idProducto, $idBoleta);
                }
            }
            return $idBoleta;
        }

        public function actualizarStock($listaProductos){
            foreach ($listaProductos as $listaProducto) {
                $idProducto = $listaProducto["idProducto"];
                $cantidad = $listaProducto["cantidad"];
                $objProducto = new Producto;
                $respuesta = $objProducto->actualizarStockBD($idProducto, $cantidad);
            }
            return $respuesta;
        }
        public function actualizarEstado($idProforma){
            $objProforma = new proforma;
            $objProforma->actualizarEstado($idProforma);
        }

        public function listaDetalleBoleta($idBoleta){
            $objBoleta = new boleta;
            $listaDetalleBoleta = $objBoleta->obtenerDetalleBoleta($idBoleta);
            $objVerBoleta = new formVerBoleta;
            $objVerBoleta->formVerBoletaShow($listaDetalleBoleta);

        }
        
        

    }

?>