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

        public function obtenerDetalleBoleta($idBoleta){
            $conexion = Conecta::conectarBD();
            $sql = "SELECT b.idBoleta,b.numeroBoleta, b.fechaEmitida, b.horaEmitida, b.cajeroEmitida, b.total, b.estado,
                            db.cantidad, db.precioUnitario, db.precioTotal,
                            pr.codigo, pr.producto
                FROM boleta b
                JOIN detalleBoleta db ON b.idBoleta = db.idBoleta
                JOIN producto pr ON db.idProducto = pr.idProducto
                WHERE b.idBoleta = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $idBoleta);
        $stmt->execute();
        $detalleBoleta = $stmt->get_result();
        // Convierte el resultado a un array
        $listaDetalleBoleta = [];
        while ($row = $detalleBoleta->fetch_assoc()) {
            $listaDetalleBoleta[] = $row;
        }
        $stmt->close();
        Conecta::desConectaBD();
        // Retorna el array en lugar del objeto mysqli_result
        return $listaDetalleBoleta;
        }
    }
?>