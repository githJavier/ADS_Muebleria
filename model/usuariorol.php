<?php
include_once("Conecta.php");

class UsuarioRol {
    public function asignarRol($idUsuario, $idRol)
    {
        $conexion = Conecta::conectarBD();
        $sql = "INSERT INTO usuariorol (idUsuario, idRol) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            Conecta::desConectaBD();
            die("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("ii", $idUsuario, $idRol);

        if ($stmt->execute()) {
            Conecta::desConectaBD();
            return true; // Inserción exitosa
        } else {
            Conecta::desConectaBD();
            die("Error al insertar el rol: " . $stmt->error); // Agregar un mensaje de error más claro
        }
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

    public function eliminarRolesPorUsuario($idUsuario)
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

        // Preparar y ejecutar la consulta
        $sql = "DELETE FROM usuariorol WHERE idUsuario = $idUsuario";

        // Ejecutar la consulta directamente sin preparar parámetros
        if (mysqli_query($conexion, $sql)) {
            Conecta::desConectaBD();
            return true; // Eliminación exitosa
        } else {
            Conecta::desConectaBD();
            die("Error al eliminar roles: " . mysqli_error($conexion)); // Mejor manejo de errores
        }
    }



}
?>
