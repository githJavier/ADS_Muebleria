<?php
include_once("Conecta.php");

class categoria{
    public function listarCategoria()
    {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT * FROM categoria;";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $listaCategoria = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        Conecta::desConectaBD();
        return $listaCategoria;
    }
        
}