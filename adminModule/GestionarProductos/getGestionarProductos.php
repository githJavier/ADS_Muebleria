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
                $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "getProforma.php");
            }
        }else{
            $objControlGestionarProducto = new controlGestionarProducto;
            $objControlGestionarProducto->listarProductosCategoria();

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Ingrese id o nombre de producto válido", "getProforma.php");
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

        $objCrear = new controlGestionarProducto();
        $objCrear->crearProducto($codigo, $producto, $categoria, $precio, $cantidad);
        
        $objControlGestionarProducto = new controlGestionarProducto;
        $objControlGestionarProducto->listarProductosCategoria();
    }else if(validaBoton($btnEditar)){

    }else if(validaBoton($btnEliminar)){
        
    }
?>