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
        $sql = "SELECT nombre, apellido, correo, telefono, nombreUsuario, estado FROM usuario";
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
}
?>
