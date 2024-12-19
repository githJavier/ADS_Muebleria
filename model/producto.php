<?php
include_once("Conecta.php");

class producto{

    public function listarProductos()
    {
        $conexion = Conecta::conectarBD();
        $sql = "SELECT * FROM producto";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $listaProductos = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        Conecta::desConectaBD();
        return $listaProductos;
    }

    
    public function obtenerProductosBusqueda($txtBuscarProducto)
{
    $terminos = explode(' ', $txtBuscarProducto);
    $condiciones = [];
    $parametros = [];
    $tipos = '';
    foreach ($terminos as $termino) {
        $condiciones[] = "(idProducto LIKE ? OR codigo LIKE ? OR LOWER(producto) LIKE ?)";
        $paramTerm = '%' . $termino . '%';
        $parametros[] = $paramTerm;
        $parametros[] = $paramTerm;
        $parametros[] = $paramTerm;
        $tipos .= 'sss';
    }
    $sql = "SELECT * FROM producto WHERE " . implode(' AND ', $condiciones);
    $conexion = Conecta::conectarBD();
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param($tipos, ...$parametros);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $listaProductos = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    Conecta::desConectaBD();
    return $listaProductos;
}
    public function validadStockBD($idProducto){
        $conexion = Conecta::conectarBD();
        $sql = "SELECT cantidad FROM Producto WHERE idProducto = '$idProducto'";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $respuesta = $resultado->fetch_assoc();  // Usamos fetch_assoc() para obtener solo un resultado
        $stmt->close();
        Conecta::desConectaBD();
        
        // Retorna solo el valor de la cantidad
        return isset($respuesta['cantidad']) ? $respuesta['cantidad'] : 0;  // Asegúrate de retornar un valor numérico
    }
    public function actualizarStockBD($idProducto, $cantidad) {
        $conexion = Conecta::conectarBD();
        $sql = "UPDATE Producto SET cantidad = cantidad - ? WHERE idProducto = ?;";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        $stmt->bind_param("ii", $cantidad, $idProducto);
        $stmt->execute();
        $respuesta = $stmt->affected_rows > 0;
        $stmt->close();
        Conecta::desConectaBD();
        return $respuesta;
    }
    
    



}