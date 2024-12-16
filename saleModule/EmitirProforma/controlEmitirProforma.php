<?php 
include_once("./formEmitirProforma.php");
include_once("../../model/producto.php");
include_once("../../model/categoria.php");

class controlEmitirProforma{
    public function listarProductosBD(){
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos);
        
    }
    public function listarBusquedaProductos($txtBuscarProducto)
    {
        $objProducto = new producto();
        $listaProductos = $objProducto->obtenerProductosBusqueda($txtBuscarProducto);
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos);
    }


}