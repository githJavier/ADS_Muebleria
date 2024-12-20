<?php
class Conecta
{
    private static $conexion;

    public static function conectarBD()
    {
        if (!self::$conexion) {
            self::$conexion = mysqli_connect('localhost', 'root', '', 'muebleria_m');
            if (!self::$conexion) {
                die("Error al conectar a la base de datos: " . mysqli_connect_error());
            }
        }
        return self::$conexion;
    }

    public static function desConectaBD()
    {
        if (self::$conexion) {
            mysqli_close(self::$conexion);
            self::$conexion = null;
        }
    }
    public static function debuguearConexion()
    {
        echo("<pre>");
        var_dump(self::$conexion);
        echo("</pre>");
    }
}
// pruebas
// conecta::conectarBD();
// conecta::debuguearConexion();
// conecta::desConectaBD();
?>
