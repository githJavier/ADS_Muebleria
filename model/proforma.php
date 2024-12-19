<?php
require_once("Conecta.php");
class proforma 
{
    public function insertarProforma($numeroProforma,$Usuario, $fecha, $hora, $totalProforma,$subtotal,$impuesto)
    {
        $sql = "INSERT INTO proforma (numeroProforma, vendedorEmitida, fechaEmitida, horaEmitida, total, subtotal, impuesto,estado) 
        VALUES ('$numeroProforma','$Usuario', '$fecha', '$hora', '$totalProforma', '$subtotal', '$impuesto','Pendiente')";
        $conexion = Conecta::conectarBD();
        
        if ($conexion->query($sql) === TRUE) {
            $idProforma = $conexion->insert_id;
            Conecta::desConectaBD();
            return $idProforma;
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
            Conecta::desConectaBD();
            return false;
        }
    }
    //Agregue el public
    public function generarNumeroProforma($year, $month) {
        // Obtiene el último número proforma generado para el mes actual
        $sql = "SELECT numeroProforma FROM proforma WHERE numeroProforma LIKE '$year$month%' ORDER BY numeroProforma DESC LIMIT 1";
        $result = mysqli_query(Conecta::conectarBD(), $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            // Si existe un número proforma, extrae la secuencia y la incrementa
            $row = mysqli_fetch_assoc($result);
            $lastNumero = $row['numeroProforma'];
            $sequence = substr($lastNumero, 6);  // Extrae la parte numérica (00001)
            $newSequence = str_pad($sequence + 1, 5, "0", STR_PAD_LEFT);  // Incrementa y rellena con ceros
        } else {
            // Si no existe ningún número proforma, comienza desde 1
            $newSequence = '00001';
        }
        // Genera el nuevo número proforma
        return $year . $month . $newSequence;
    }

    public function listarProformas()
    {
        $sql = "SELECT * FROM proforma WHERE estado='Pendiente'";
        $conexion = Conecta::conectarBD();
        $resultado = $conexion->query($sql);
        Conecta::desConectaBD();
        return $resultado;
    }
    public function obtenerProformasBusqueda($txtBuscarProforma){
        $sql = "SELECT * FROM proforma WHERE numeroProforma = ? AND estado = 'Pendiente'";
        $conexion = Conecta::conectarBD();
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $txtBuscarProforma);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $listaProformas = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        Conecta::desConectaBD();
        return $listaProformas;
    }
    public function obtenerDetalleProforma($idProforma) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT p.idProforma, p.total, dp.Cantidad, pr.producto, pr.idProducto, dp.precioUnitario, dp.PrecioTotal
                FROM proforma p
                JOIN detalleProforma dp ON p.idProforma = dp.idProforma
                JOIN producto pr ON dp.idProducto = pr.idProducto
                WHERE p.idProforma = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $idProforma);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        // Convierte el resultado a un array
        $listaDetalleProforma = [];
        while ($row = $resultado->fetch_assoc()) {
            $listaDetalleProforma[] = $row;
        }
    
        $stmt->close();
        Conecta::desConectaBD();
    
        // Retorna el array en lugar del objeto mysqli_result
        return $listaDetalleProforma;
    }
    
    public function actualizarEstado($idProforma){
        $conexion = Conecta::conectarBD();
        $sql = "UPDATE proforma SET estado = 'Atendida' WHERE idProforma = ?;";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        $stmt->bind_param("i", $idProforma);
        $stmt->execute();
        $stmt->close();
        Conecta::desConectaBD();
    }
    

}