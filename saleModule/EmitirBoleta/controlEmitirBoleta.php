<?php 
include_once("../../model/proforma.php");
include_once("./formEmitirBoleta.php");
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
    }

?>