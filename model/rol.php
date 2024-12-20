<?php 
include_once("Conecta.php");
class rol{
    public function obtenerRol($usuario){
        $conexion = Conecta::conectarBD();
        $sql = "
        SELECT rol.nombre_rol
        FROM usuariorol
        INNER JOIN usuario ON usuariorol.idUsuario = usuario.idUsuario
        INNER JOIN rol ON usuariorol.idRol = rol.idRol
        WHERE usuario.nombre = '$usuario';";
        $resultado = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            $rol = $fila['nombre_rol'];
        } else {
            $rol = null;
        }
        Conecta::desConectaBD();
        return $rol;
    }


    // 
    public function listarRoles() {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idRol, nombre_rol FROM rol";
        $resultado = mysqli_query($conexion, $sql);
        $roles = [];

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $roles[] = $fila;
            }
        }

        Conecta::desConectaBD();
        return $roles;
    }

    public function asignarRol($idUsuario, $idRol) {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuariorol (idUsuario, idRol) VALUES ($idUsuario, $idRol)";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }
}
?>