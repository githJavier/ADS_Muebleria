<?php
include_once("Conecta.php");
class usuario
{
    public function validarUsuario($usuario)
    {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT nombreUsuario FROM usuario WHERE nombreUsuario = '$usuario'";
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        Conecta::desConectaBD();

        return $numFilas === 1 ? 1 : 0;
    }

    public function verificaPassword($usuario, $clave)
    {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT nombreUsuario FROM usuario WHERE nombreUsuario = '$usuario' AND clave = '$clave'";
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        Conecta::desConectaBD();

        return $numFilas === 1 ? 1 : 0;
    }

    public function verificaEstado($usuario)
    {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT nombreUsuario FROM usuario WHERE nombreUsuario = '$usuario' AND estado = 1";
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        Conecta::desConectaBD();

        return $numFilas === 1 ? 1 : 0;
    }

    // Método para listar usuarios con columnas específicas para gestión
    public function listarUsuariosParaGestion() {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idUsuario, nombre, apellido, correo, telefono, nombreUsuario, estado FROM usuario";
        $resultado = mysqli_query($conexion, $sql);
        $usuarios = [];

        // Verificar si hay resultados y guardarlos en un arreglo
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $fila;
            }
        }

        Conecta::desConectaBD();
        return $usuarios; // Devuelve el arreglo de usuarios
    }



    public function agregarUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad) {
        $conexion = Conecta::conectarBD();
        $estadoBit = $estado === 'on' ? 1 : 0; // Checkbox devuelve 'on' si está marcado
        $sql = "INSERT INTO usuario (nombre, apellido, correo, telefono, nombreUsuario, clave, estado, preguntaSeguridad, respuestaSeguridad) 
                VALUES ('$nombre', '$apellido', '$correo', '$telefono', '$nombreUsuario', '$clave', $estadoBit, '$preguntaSeguridad', '$respuestaSeguridad')";
        $resultado = mysqli_query($conexion, $sql);
        $idUsuario = mysqli_insert_id($conexion);
        Conecta::desConectaBD();

        return $resultado ? $idUsuario : false;
    }



    public function obtenerUsuarioPorId($idUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT * FROM usuario WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $sql);
        $usuario = mysqli_fetch_assoc($resultado);
        Conecta::desConectaBD();
        return $usuario;
    }
    
    public function validarUsuarioExistente($idUsuario, $nombreUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idUsuario FROM usuario WHERE nombreUsuario = '$nombreUsuario' AND idUsuario != $idUsuario";
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        Conecta::desConectaBD();
        return $numFilas > 0;
    }
    
    public function actualizarUsuario($idUsuario, $nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad) {
        $conexion = Conecta::conectarBD();
        $estadoBit = $estado === 'on' ? 1 : 0;
        $claveQuery = $clave ? ", clave = '$clave'" : '';
        $sql = "UPDATE usuario SET 
                nombre = '$nombre',
                apellido = '$apellido',
                correo = '$correo',
                telefono = '$telefono',
                nombreUsuario = '$nombreUsuario',
                estado = $estadoBit,
                preguntaSeguridad = '$preguntaSeguridad',
                respuestaSeguridad = '$respuestaSeguridad'
                $claveQuery
                WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
        return $resultado;
    }

    public function eliminarUsuarioPorId($idUsuario) {
        $conexion = Conecta::conectarBD();
        $sql = "DELETE FROM usuario WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conexion, $sql);
        Conecta::desConectaBD();
        return $resultado;
    }


    // ✅ RECUPERAR ------------------------------------------------------------------------------------------ 
    // Obtener la pregunta de seguridad del usuario
    public function obtenerPreguntaSeguridad($usuario) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT preguntaSeguridad FROM usuario WHERE nombreUsuario = '$usuario'";
        $resultado = mysqli_query($conexion, $sql);
        $pregunta = null;

        if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
            $pregunta = $fila['preguntaSeguridad'];
        }

        Conecta::desConectaBD();
        return $pregunta;
    }
    // Verificar si el usuario existe
    public function existeUsuario($usuario) {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT idUsuario FROM usuario WHERE nombreUsuario = '$usuario'";
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        Conecta::desConectaBD();

        return $numFilas === 1;
    }
    
    
}
?>
