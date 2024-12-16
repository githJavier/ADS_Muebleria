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
}
?>
