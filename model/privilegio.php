<?php
include_once("Conecta.php");

class privilegio {
    public function listarPrivilegios() {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idPrivilegio, labelPrivilegio FROM privilegio";
        $resultado = mysqli_query($conexion, $sql);
        $privilegios = [];

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $privilegios[] = $fila;
            }
        }

        Conecta::desConectaBD();
        return $privilegios;
    }

    
}
?>
