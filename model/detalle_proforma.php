<?php
require_once("Conecta.php");

class detalle_proforma
{
    public function registrarDetalleProforma($idProforma, $idProducto, $cantidad, $subtotal,$precioTotalProducto)
    {
        $sql = "INSERT INTO detalleproforma (idProforma, idProducto, cantidad,precioUnitario, precioTotal) VALUES ('$idProforma', '$idProducto', '$cantidad', '$subtotal','$precioTotalProducto')";
        $conexion = Conecta::conectarBD();
        
        if ($conexion->query($sql) === TRUE) {
            Conecta::desConectaBD();
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
            Conecta::desConectaBD();
            return false;
        }
    }
}