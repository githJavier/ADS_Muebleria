<?php
include_once("Conecta.php");

class UsuarioRol {
    public function asignarRol($idUsuario, $idRol) {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuariorol (idUsuario, idRol) VALUES ($idUsuario, $idRol)";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }

    public function obtenerRolesPorUsuario($idUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idRol FROM usuariorol WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $sql);
        $rolesAsignados = [];

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $rolesAsignados[] = $fila['idRol'];
            }
        }

        Conecta::desConectaBD();
        return $rolesAsignados;
    }

    public function eliminarRolesPorUsuario($idUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "DELETE FROM usuariorol WHERE idUsuario = $idUsuario";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }
}
?>
