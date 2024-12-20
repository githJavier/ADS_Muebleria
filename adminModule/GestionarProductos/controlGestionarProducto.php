<?php
include_once("../../model/producto.php");
include_once("../../model/categoria.php");
include_once("./formGestionarProducto.php");
include_once("./formAgregarProducto.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../model/ProductoCategoria.php");
    class controlGestionarProducto{
        public function listarProductosCategoria(){
            $producto = new Producto();
            $listaProductos = $producto->listarProductosConCategoria();
            $categoria = new Categoria();
            $listaCategorias = $categoria->listarCategoria();
            $form = new formGestionarProducto();
            $form->formGestionarProductoShow($listaProductos, $listaCategorias);
        }
        public function listarBusquedaProductosCategoria($txtBuscarProducto) {
            $objProducto = new producto();
            $listaProductos = $objProducto->buscarProductosConCategoria($txtBuscarProducto);
            $categoria = new Categoria();
            $listaCategorias = $categoria->listarCategoria();
            $form = new formGestionarProducto();
            $form->formGestionarProductoShow($listaProductos, $listaCategorias);
        }
        public function agregarProducto() {
            
            $categoriaModel = new categoria();
            $listaCategorias = $categoriaModel->listarCategoria(); 

            $form = new formAgregarProducto;
            $form->formAgregarProductoShow($listaCategorias);
        }
        public function crearProducto( $codigo, $producto, $categoria, $precio, $cantidad ) {
            // Verificar si el producto ya existe por nombre    
            $modeloProducto = new producto();
            if ($modeloProducto->verificarProductoPorNombre($producto)) {
                return false;
            }      
            $idProducto = $modeloProducto->crearProducto($codigo, $producto, $precio, $cantidad);
            if (!$idProducto) {
                return false;
            }
    
            $modeloProductoCategoria = new ProductoCategoria();
            $categoriaAsignada = $modeloProductoCategoria->asignarCategoria($idProducto, $categoria);
            if (!$categoriaAsignada) {
                return false;
            }
            
        }
    }

?>
