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
    function generarNumeroProforma($year, $month) {
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

}