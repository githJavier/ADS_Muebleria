<?php 
include_once("Conecta.php");
class rol{
    public function obtenerRol($usuario) {
        $conexion = Conecta::conectarBD();
        $sql = "
        SELECT rol.nombre_rol
        FROM usuariorol
        INNER JOIN usuario ON usuariorol.idUsuario = usuario.idUsuario
        INNER JOIN rol ON usuariorol.idRol = rol.idRol
        WHERE usuario.nombreUsuario = ?";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario); // "s" indica que el parámetro es una cadena
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $rol = $fila['nombre_rol'];
        } else {
            $rol = null;
        }
    
        $stmt->close();
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

    public function validarRolExistente($idRol) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT COUNT(*) AS total FROM rol WHERE idRol = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idRol);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        Conecta::desConectaBD();

        return $fila['total'] > 0;
    }

    public function asignarRol($idUsuario, $idRol) {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuariorol (idUsuario, idRol) VALUES ($idUsuario, $idRol)";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }
}
?>