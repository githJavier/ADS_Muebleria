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
}
?>