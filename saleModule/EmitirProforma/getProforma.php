<?php 
include_once("controlEmitirProforma.php");
session_start();

function validaBoton($boton) {
    return isset($boton);
}
function verificarSesionIniciada()
{
    return isset($_SESSION['usuario']);
}
function verificarCamposVacios($txtBuscarProducto)
{
    return ($txtBuscarProducto != "");
}
function verificarCaracteresEspeciales($txtBuscarProducto)
{
    if (preg_match("/[^a-zA-Z0-9áéíóúÁÉÍÓÚ\s]/", $txtBuscarProducto)) {
        return true;
    } else {
        return false;
    }
}
//Declaracion de Botones
$btnEmitirProforma = $_POST['btnEmitirProforma'] ?? null;
$btnBuscarProducto = $_POST['btnBuscarProducto'] ?? null;
if(validaBoton($btnEmitirProforma)){
    if(verificarSesionIniciada()){
        $objControlEmitirProforma = new controlEmitirProforma();
        $objControlEmitirProforma->listarProductosBD();
        
    }else{
        header('Location: ../../securityModule/panelPrincipalUsuario.php');
        exit;
    }
}else if(validaBoton($btnBuscarProducto)){
    $txtBuscarProducto = $_POST['txtBuscarProducto'];
    
}
?>