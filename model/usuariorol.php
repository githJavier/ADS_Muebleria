<?php
include_once("Conecta.php");

class UsuarioRol {
    public function asignarRol($idUsuario, $idRol) {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuariorol (idUsuario, idRol) VALUES ($idUsuario, $idRol)";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }
}
?>
