<?php 
session_start();
include_once("controlEmitirProforma.php");
include_once("../../shared/mensajeSistema.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");

function validaBoton($boton) {
    return isset($boton);
}

function verificarSesionIniciada() {
    return isset($_SESSION['usuario']);
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
function mostrarMensaje($mensaje){
    $objMensaje = new MensajeVulnerabilidadSistema();
    $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
}

function verificarExistenciaProductos($listaProductos) {
    return !empty($listaProductos);
}

function crearListaProforma($idProductos, $cantidades, $precioUnitario) {
    $listaProforma = [];

    for ($i = 0; $i < count($idProductos); $i++) {
        $listaProforma[$i]["idProducto"] = $idProductos[$i];
        $listaProforma[$i]["cantidad"] = $cantidades[$i];
        $listaProforma[$i]["subtotal"] = $precioUnitario[$i];
    }

    return $listaProforma;
}

// Declaración de Botones
$btnEmitirProforma = $_POST['btnEmitirProforma'] ?? null;
$btnBuscarProducto = $_POST['btnBuscarProducto'] ?? null;
$btnGenerarProforma = $_POST['btnGenerarProforma'] ?? null;

if (validaBoton($btnEmitirProforma)) {
    if (verificarSesionIniciada()) {
        $objControlEmitirProforma = new controlEmitirProforma();
        $objControlEmitirProforma->listarProductosBD();
    } else {
        mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
        exit;
    }
} else if (validaBoton($btnBuscarProducto)) {
    $txtBuscarProducto = $_POST['txtBuscarProducto'];
    if (verificarCamposVacios($txtBuscarProducto)) {
        if (!verificarCaracteresEspeciales($txtBuscarProducto)) {
            $objControlEmitirProforma = new controlEmitirProforma();
            $objControlEmitirProforma->listarBusquedaProductos($txtBuscarProducto);
        } else {
            $objProducto = new producto();
            $listaProductos = $objProducto->listarProductos();
            $objFormEmitirProforma = new formEmitirProforma();
            $objFormEmitirProforma->formEmitirProformaShow($listaProductos);

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "getProforma.php");
        }
    } else {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese id o nombre de producto válido", "getProforma.php");
    }
} else if (validaBoton($btnGenerarProforma)) {
    // Capturar los productos seleccionados enviados como JSON
    $selectedProductsJson = $_POST['selectedProducts'] ?? '[]';
    $selectedProducts = json_decode($selectedProductsJson, true);

    // Verificar que haya productos seleccionados
    if (empty($selectedProducts)) {
        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("No se ha seleccionado ningún producto", "getProforma.php");
    } else {
        $totalProforma = 0;
        $idProductos = [];
        $cantidades = [];
        $precios = [];
        $impuestos = [];

        foreach ($selectedProducts as $product) {
            $id = htmlspecialchars($product['id']);
            $precio = htmlspecialchars($product['price']);
            $cantidad = htmlspecialchars($product['quantity']);
            $totalProducto = $precio * $cantidad;
            $subtotal = ($totalProducto * 0.72);
            $impuesto = ($totalProducto * 0.18);  // Corregido cálculo del impuesto

            // Añadir los productos a los arrays correspondientes
            $idProductos[] = $id;
            $cantidades[] = $cantidad;
            $precios[] = $subtotal;

            // Acumular el total de la proforma
            $totalProforma += $totalProducto;
        }

        // Verificar si se han agregado productos
        if (verificarExistenciaProductos($idProductos)) {
            $listaProforma = crearListaProforma($idProductos, $cantidades, $precios);
            $objControlEmitirProforma = new controlEmitirProforma();
            $objControlEmitirProforma->emitirProforma($listaProforma, $totalProforma, $_SESSION['usuario']);
        } else {
            $objProducto = new producto();
            $listaProductos = $objProducto->listarProductos();
            // Si no hay productos agregados
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("No se ha agregado ningún producto", "getProforma.php");
        }
    }
} else {
    mostrarMensaje("Acceso denegado. Se detectó un intento de acceso ilegal.");
    exit;
}
?>
