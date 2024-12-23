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
        } else {
            throw new Exception("Error en la consulta: " . mysqli_error($conexion));
        }

        Conecta::desConectaBD();
        return $privilegios;
    }

    public function validarPrivilegioExistente($idPrivilegio) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT COUNT(*) AS total FROM privilegio WHERE idPrivilegio = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idPrivilegio);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        Conecta::desConectaBD();

        return $fila['total'] > 0;
    }

    
}
?>
