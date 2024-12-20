<?php
include_once("Conecta.php");

class ProductoCategoria{

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
public function asignarCategoria($idProducto, $idCategoria)
{
    $conexion = Conecta::conectarBD();
    $sql = "INSERT INTO productocategoria (idProducto, idCategoria) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $idProducto, $idCategoria);
    $resultado = $stmt->execute();
    $stmt->close();
    Conecta::desConectaBD();
    return $resultado;
}


}