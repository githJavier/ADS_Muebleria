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

    public function asignarPrivilegio($idUsuario, $idPrivilegio)
    {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuarioPrivilegio (idUsuario, idPrivilegio) VALUES ($idUsuario, $idPrivilegio)";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $sql)) {
            Conecta::desConectaBD();
            return true; // Inserción exitosa
        } else {
            Conecta::desConectaBD();
            return false; // Error en la inserción
        }
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


    public function eliminarPrivilegiosPorUsuario($idUsuario)
    {
        // Validar el ID del usuario
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            die("El ID de usuario proporcionado no es válido.");
        }

        // Conectar a la base de datos
        $conexion = Conecta::conectarBD();
        if (!$conexion) {
            die("Error al conectar con la base de datos: " . mysqli_connect_error());
        }

        // Preparar y ejecutar la consulta para eliminar privilegios
        $sql = "DELETE FROM usuarioPrivilegio WHERE idUsuario = $idUsuario";

        // Ejecutar la consulta directamente
        if (mysqli_query($conexion, $sql)) {
            Conecta::desConectaBD();
            return true; // Eliminación exitosa
        } else {
            Conecta::desConectaBD();
            die("Error al eliminar privilegios: " . mysqli_error($conexion)); // Mejor manejo de errores
        }
    }

}
?>
