<?php
include_once("Conecta.php");
class UsuarioPrivilegio
{
    public function obtenerPrivilegios($usuario)
    {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT 
                    P.labelPrivilegio, 
                    P.pathPrivilegio, 
                    P.iconPrivilegio,
                    P.name
                FROM 
                    usuarioPrivilegio UP
                JOIN 
                    privilegio P
                    ON UP.idPrivilegio = P.idPrivilegio
                JOIN 
                    usuario U
                    ON UP.idUsuario = U.idUsuario
                WHERE 
                    U.nombreUsuario = '$usuario';";
        $resultado = mysqli_query($conexion, $sql);
        $fila = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $fila[] = $row;
            }
        }
        Conecta::desConectaBD();

        return $fila;
    }

    public function asignarPrivilegio($idUsuario, $idPrivilegio) {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuarioPrivilegio (idUsuario, idPrivilegio) VALUES ($idUsuario, $idPrivilegio)";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }

    public function obtenerPrivilegiosPorUsuario($idUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idPrivilegio FROM usuarioPrivilegio WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $sql);
        $privilegiosAsignados = [];

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $privilegiosAsignados[] = $fila['idPrivilegio'];
            }
        }

        Conecta::desConectaBD();
        return $privilegiosAsignados;
    }


    public function eliminarPrivilegiosPorUsuario($idUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "DELETE FROM usuarioPrivilegio WHERE idUsuario = $idUsuario";
        mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
    }
}
?>
