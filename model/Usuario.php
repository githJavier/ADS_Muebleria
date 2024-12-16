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
}
?>
