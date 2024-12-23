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

    public function validarPrivilegioExistente($idPrivilegio) {
        include_once 'conexion.php'; // Asegúrate de que esto apunta correctamente a tu conexión
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
