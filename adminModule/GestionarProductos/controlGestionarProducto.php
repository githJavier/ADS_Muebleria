<?php
include_once("../../model/producto.php");
include_once("../../model/categoria.php");
include_once("./formGestionarProducto.php");
include_once("./formAgregarProducto.php");
include_once("./formEditarProducto.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../model/ProductoCategoria.php");
    class controlGestionarProducto{
        public function listarProductosCategoria(){
            $producto = new Producto();
            $listaProductos = $producto->listarProductosConCategoria();
            $form = new formGestionarProducto();
            $form->formGestionarProductoShow($listaProductos);
        }
        public function listarBusquedaProductosCategoria($txtBuscarProducto) {
            $objProducto = new producto();
            $listaProductos = $objProducto->buscarProductosConCategoria($txtBuscarProducto);
            $objMensajeSistema = new mensajeSistema();
            if($listaProductos == null){
                $this->listarProductosCategoria();
                $objMensajeSistema->mensajeSistemaShow("Producto no encontrado.", "getGestionarProductos.php");
            }else{
                $form = new formGestionarProducto();
                $form->formGestionarProductoShow($listaProductos);
            }
        }
        public function agregarProducto() {
            
            $categoriaModel = new categoria();
            $listaCategorias = $categoriaModel->listarCategoria(); 
            $producto = new producto();
            $codigoNuevo = $producto->crearCodigo();
            $form = new formAgregarProducto;
            $form->formAgregarProductoShow($listaCategorias, $codigoNuevo);
        }
        public function crearProducto( $codigo, $producto, $categoria, $precio, $cantidad ) {
            // Verificar si el producto ya existe por nombre    
            $modeloProducto = new producto();
            if ($modeloProducto->verificarProductoPorNombre($producto)) {
                return false;
            } 
            else{
                $idProducto = $modeloProducto->crearProducto($codigo, $producto, $precio, $cantidad);
                $modeloProductoCategoria = new ProductoCategoria();
                $modeloProductoCategoria->asignarCategoria($idProducto, $categoria);
                return true;
            }    
        }
        public function editarProducto($idProducto){
            $objProducto = new producto;
            $producto = $objProducto->buscarProductoId($idProducto);
            $objCategoria = new categoria;
            $listaCategorias = $objCategoria->listarCategoria();
            $objformEditcarCategoria = new formEditarProducto;
            $objformEditcarCategoria->formEditarProductoShow($producto, $listaCategorias);
        }
        public function guardarEditarProducto($idProducto, $producto,$precio, $cantidad, $idCategoria){
            $objProducto = new producto;
            $objProducto->actualizarProducto($idProducto, $producto,$precio, $cantidad);
            $objProductoCategoria = new ProductoCategoria;
            $objProductoCategoria->actualizarCategoria($idCategoria, $idProducto);
        }

        public function eliminarProducto($idProducto){
            $objProducto = new producto;
            $objProducto->actualizarEstadoProducto($idProducto);
            $listaProductos = $objProducto->listarProductosConCategoria();
            $form = new formGestionarProducto();
            $form->formGestionarProductoShow($listaProductos);
        }
    }

?>
