<?php
include_once("./controlGestionarProducto.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");

    session_start();

    function validaBoton($boton) {
        return isset($boton);
    }
    function verificarSesionIniciada() {
        return isset($_SESSION['usuario']);
    }
    function mostrarMensaje($mensaje){
        $objMensaje = new MensajeVulnerabilidadSistema();
        $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
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
    
    //Declaracion de Botones
    $btnGestionarProducto = $_POST['btnGestionarProducto'] ?? null;
    $btnBuscarProducto = $_POST['btnBuscarProducto'] ?? null;
    $btnAgregarProducto = $_POST['btnAgregarProducto'] ?? null;
    $btnCrearProducto = $_POST['btnCrearProducto'] ?? null;
    $btnEditar = $_POST['btnEditar'] ?? null;
    $btnEliminar = $_POST['btnEliminar'] ?? null;
    $btnGuardarDatos = $_POST['btnGuardarDatos'] ?? null;


    if(validaBoton($btnGestionarProducto)){
        if (verificarSesionIniciada()) {
            $objControlGestionarProducto = new controlGestionarProducto;
            $objControlGestionarProducto->listarProductosCategoria();
        }else {
            mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
        }
    }else if (validaBoton($btnBuscarProducto)) {
        $txtBuscarProducto = $_POST['txtBuscarProducto'];
        if (verificarCamposVacios($txtBuscarProducto)) {
            if (!verificarCaracteresEspeciales($txtBuscarProducto)) {
                $objControlGestionarProducto = new controlGestionarProducto;
                $objControlGestionarProducto->listarBusquedaProductosCategoria($txtBuscarProducto);
            } else {
                $objControlGestionarProducto = new controlGestionarProducto;
                $objControlGestionarProducto->listarProductosCategoria();

                $objMensajeSistema = new mensajeSistema();
                $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "getGestionarProductos.php");
            }
        }else{
            $objControlGestionarProducto = new controlGestionarProducto;
            $objControlGestionarProducto->listarProductosCategoria();

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Ingrese id o nombre de producto válido", "getGestionarProductos.php");
        }
    }elseif (validaBoton($btnAgregarProducto)) {
        $objAgregar = new controlGestionarProducto();
        $objAgregar->agregarProducto();
    }else if(validaBoton($btnCrearProducto)){
        // Extraer datos
        $codigo = $_POST['txtCodigo'];
        $producto = $_POST['txtProducto'];
        $categoria = $_POST['opcCategoria'];
        $precio = $_POST['txtPrecio'];
        $cantidad = $_POST['txtCantidad'];
        if(verificarCamposVacios($producto) && !verificarCaracteresEspeciales($producto)){
            if(verificarCamposVacios($categoria)){
                if(verificarCamposVacios($precio)){
                    if(verificarCamposVacios($cantidad)){
                        $objCrear = new controlGestionarProducto();
                        $respuesta = $objCrear->crearProducto($codigo, $producto, $categoria, $precio, $cantidad);
                        if($respuesta){
                            $objControlGestionarProducto = new controlGestionarProducto;
                            $objControlGestionarProducto->listarProductosCategoria();
                            $objMensajeSistema = new mensajeSistema();
                            $objMensajeSistema->mensajeSistemaShow("Producto agregado Correctamente", "getGestionarProductos.php", suceso:true);
                        }else{
                            $objAgregar = new controlGestionarProducto();
                            $objAgregar->agregarProducto();
                            $objMensajeSistema = new mensajeSistema();
                            $objMensajeSistema->mensajeSistemaShow("El producto ya existe", "getGestionarProductos.php");

                        }
                    }else{
                        $objAgregar = new controlGestionarProducto();
                        $objAgregar->agregarProducto();
                        $objMensajeSistema = new mensajeSistema();
                        $objMensajeSistema->mensajeSistemaShow("Ingresa la cantidad del producto", "getGestionarProductos.php");
                    }
                }else{
                    $objAgregar = new controlGestionarProducto();
                    $objAgregar->agregarProducto();
                    $objMensajeSistema = new mensajeSistema();
                    $objMensajeSistema->mensajeSistemaShow("Ingresa el precio del producto", "getGestionarProductos.php");
                }
            }else{
                $objAgregar = new controlGestionarProducto();
                $objAgregar->agregarProducto();
                $objMensajeSistema = new mensajeSistema();
                $objMensajeSistema->mensajeSistemaShow("Seleccione la categoria", "getGestionarProductos.php");
            }
        }else{
            $objAgregar = new controlGestionarProducto();
            $objAgregar->agregarProducto();
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Ingrese el nombre del producto y/o verifique que no tenga caracteres especiales", "getGestionarProductos.php");
        }
        
    }else if(validaBoton($btnEditar)){
        $idProducto = $_POST['btnEditar'];
        $objControlGestionarProducto = new controlGestionarProducto;
        $objControlGestionarProducto->editarProducto($idProducto);
    
        
    }else if(validaBoton($btnGuardarDatos)){
        // Extraer datos
        $idProducto = $_POST['btnGuardarDatos'];
        $producto = $_POST['txtProducto'];
        $categoria = $_POST['opcCategoria'];
        $precio = $_POST['txtPrecio'];
        $cantidad = $_POST['txtCantidad'];
        if(verificarCamposVacios($producto) && !verificarCaracteresEspeciales($producto)){
            if(verificarCamposVacios($categoria)){
                if(verificarCamposVacios($precio)){
                    if(verificarCamposVacios($cantidad)){
                        $modeloProducto = new producto();
                        if (!$modeloProducto->verificarProductoPorNombreEditar($producto, $idProducto)) {
                            $objControlGestionarProducto = new controlGestionarProducto;
                            $objControlGestionarProducto->guardarEditarProducto($idProducto,$producto,$precio,$cantidad,$categoria);
                            $objControlGestionarProducto->listarProductosCategoria();
                            $objMensajeSistema = new mensajeSistema();
                            $objMensajeSistema->mensajeSistemaShow("Datos Actualizados Correctamente", "getGestionarProductos.php", suceso:true);
                        }else{
                            $objControlGestionarProducto = new controlGestionarProducto;
                            $objControlGestionarProducto->editarProducto($idProducto);
                            $objMensajeSistema = new mensajeSistema();
                            $objMensajeSistema->mensajeSistemaShow("El producto ya existe", "getGestionarProductos.php");
                        }    
                    }else{
                        $objControlGestionarProducto = new controlGestionarProducto;
                        $objControlGestionarProducto->editarProducto($idProducto);
                        $objMensajeSistema = new mensajeSistema();
                        $objMensajeSistema->mensajeSistemaShow("Ingresa la cantidad del producto", "getGestionarProductos.php");
                    }
                }else{
                    $objControlGestionarProducto = new controlGestionarProducto;
                    $objControlGestionarProducto->editarProducto($idProducto);
                    $objMensajeSistema = new mensajeSistema();
                    $objMensajeSistema->mensajeSistemaShow("Ingresa el precio del producto", "getGestionarProductos.php");
                }
            }else{
                $objControlGestionarProducto = new controlGestionarProducto;
                $objControlGestionarProducto->editarProducto($idProducto);
                $objMensajeSistema = new mensajeSistema();
                $objMensajeSistema->mensajeSistemaShow("Seleccione la categoria", "getGestionarProductos.php");
            }
        }else{
            $objControlGestionarProducto = new controlGestionarProducto;
            $objControlGestionarProducto->editarProducto($idProducto);
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Ingrese el nombre del producto y/o verifique que no tenga caracteres especiales", "getGestionarProductos.php");
        }

    }
    else if(validaBoton($btnEliminar)){
        $idProducto = $_POST['btnEliminar'];
        $objControlGestionarProducto = new controlGestionarProducto;
        $objControlGestionarProducto->eliminarProducto($idProducto);
        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Se elimino de la lista correctamente", "getGestionarProductos.php",suceso:true);
        
    }else{
        mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
        exit;
    }
?>