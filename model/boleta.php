<?php
include_once("Conecta.php");
    class boleta{
        public function insertarBoleta($numeroBoleta, $fechaEmitida, $horaEmitida, $cajeroEmitida, $impuesto, $subtotal, $total,$tipoPago){
            $sql = "INSERT INTO boleta (numeroBoleta, fechaEmitida, horaEmitida, cajeroEmitida, impuesto, subtotal, total, estado, idTipoPago) 
                        VALUES ('$numeroBoleta', '$fechaEmitida', '$horaEmitida', '$cajeroEmitida', '$impuesto', '$subtotal', '$total', 'Pagada','$tipoPago')";
            $conexion = Conecta::conectarBD();
            if ($conexion->query($sql) === TRUE) {
                $idBoleta = $conexion->insert_id;
                Conecta::desConectaBD();
                return $idBoleta;
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
                Conecta::desConectaBD();
                return false;
            }

        }
        
        public function generarNumeroBoleta($year, $month) {
            $lastDigitYear = substr($year, -2);
            $prefix = "BOL" . $lastDigitYear . str_pad($month, 2, "0", STR_PAD_LEFT);
            $sql = "SELECT numeroBoleta FROM boleta WHERE numeroBoleta LIKE '$prefix%' ORDER BY numeroBoleta DESC LIMIT 1";
            $result = mysqli_query(Conecta::conectarBD(), $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $lastNumero = $row['numeroBoleta'];
                $sequence = substr($lastNumero, -5); // Extrae la parte numérica (XXXXX)
                $newSequence = str_pad($sequence + 1, 5, "0", STR_PAD_LEFT); // Incrementa y rellena con ceros
            } else {
                $newSequence = '00001';
            }
            return $prefix . $newSequence;
        }
        public function obtenerDetalleBoleta($idBoleta){
            $conexion = Conecta::conectarBD();
            $sql = "SELECT b.numeroBoleta, b.fechaEmitida, b.horaEmitida, b.cajeroEmitida, b.impuesto, b.subtotal, b.total, b.estado, 
                           pr.producto, db.cantidad, db.precioUnitario, db.precioTotal, tp.tipo 
                    FROM boleta b 
                    JOIN detalleBoleta db ON b.idBoleta = db.idBoleta 
                    JOIN producto pr ON db.idProducto = pr.idProducto 
                    JOIN tipopago tp ON b.idTipoPago = tp.idTipoPago 
                    WHERE b.idBoleta = ?;";
        
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param('i', $idBoleta);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            // Crear un arreglo para almacenar los resultados
            $detallesBoleta = [];
            while ($fila = $resultado->fetch_assoc()) {
                $detallesBoleta[] = $fila; // Almacena cada fila en el arreglo
            }
        
            $stmt->close();
            Conecta::desConectaBD();
        
            // Devolver el arreglo con los resultados
            return $detallesBoleta;
        }

        public function obtenerBoletaBusqueda($txtBuscarBoleta) {
            $sql = "SELECT * FROM boleta WHERE numeroBoleta = ? AND estado = 'Pagada'";
            $conexion = Conecta::conectarBD();
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $txtBuscarBoleta);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $boleta = $resultado->fetch_assoc();
            $stmt->close();
            Conecta::desConectaBD();
            return $boleta;
        }
        public function actualizarBoleta($idBoleta) {
            $conexion = Conecta::conectarBD();
            $sql = "UPDATE boleta SET estado = 'Despachada' WHERE idBoleta = ? AND estado = 'Pagada'";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $idBoleta);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $resultado = true;
            } else {
                $resultado = false;
            }
            $stmt->close();
            Conecta::desConectaBD();
            return $resultado;
        }
        
        
    }


?>