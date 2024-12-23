<?php 
include_once("../../model/boleta.php");
include_once("../../model/detalle_boleta.php");
include_once("./formVisualizarVenta.php");
include_once("./formVerDetalleBoleta.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");
class controlVisualizarVenta {
    public function listaBusquedaBoleta($txtBuscarBoleta) {
        $objboleta = new boleta();
        $resultado = $objboleta->obtenerBoletaBusqueda($txtBuscarBoleta);
        if($resultado){ 
            $objFormVisualizarBoleta = new formVisualizarVenta;
            $objFormVisualizarBoleta->formVisualizarVentaShow($resultado);
        }else{
            $objFormVisualizarBoleta = new formVisualizarVenta;
            $objFormVisualizarBoleta->formVisualizarVentaShow(null);
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("no se encontro la boleta.", "getVisualizarVenta.php");
        }
    }

    public function obtenerDatosDetalleBoleta($idBoleta){
        $obtenerDetalleBoleta = new detalle_boleta;
        $detalleBoleta = $obtenerDetalleBoleta->obtenerDetalleBoleta($idBoleta);
        $objFormVisualizarDetalleBoleta = new formVerDetalleBoleta;
        $objFormVisualizarDetalleBoleta->formVerDetalleBoletaShow($detalleBoleta);
    }
    public function actualizarEstadoBoleta($idBoleta){
        $objboleta = new boleta();
        $resultado = $objboleta->actualizarBoleta($idBoleta);
        if($resultado){
            $objFormVisualizarBoleta = new formVisualizarVenta;
            $objFormVisualizarBoleta->formVisualizarVentaShow(null);
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Boleta despachada correctamente", "getVisualizarVenta.php");
        }else{
            $objFormVisualizarBoleta = new formVisualizarVenta;
            $objFormVisualizarBoleta->formVisualizarVentaShow(null);
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Boleta ya entrada", "getVisualizarVenta.php");
        }
    }
}
?>