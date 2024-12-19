<?php 
include_once("Conecta.php");
    class detalle_boleta{
        public function registrarDetalleBoleta($cantidad, $precioUnitario, $precioTotal, $idProducto, $idBoleta){
            $sql = "INSERT INTO detalleboleta (cantidad, precioUnitario, precioTotal, idProducto, idBoleta) 
                    VALUES ('$cantidad', '$precioUnitario', '$precioTotal', '$idProducto', '$idBoleta')";
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
?>