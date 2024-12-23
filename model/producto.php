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
    public function listarProductosConCategoria()
{
    $conexion = Conecta::conectarBD();
    $sql = "SELECT p.idProducto, p.codigo, p.producto, p.precio, p.cantidad, p.imagen, c.categoria 
            FROM producto p
            LEFT JOIN productocategoria pc ON p.idProducto = pc.idProducto
            LEFT JOIN categoria c ON pc.idCategoria = c.idCategoria
            WHERE estado = 'Activo'
            ORDER BY p.codigo ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $listaProductos = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    Conecta::desConectaBD();
    return $listaProductos;
}
public function buscarProductosConCategoria($txtBuscarProducto)
{
    $conexion = Conecta::conectarBD();
    $terminos = explode(' ', $txtBuscarProducto); // Divide la búsqueda en términos
    $condiciones = [];
    $parametros = [];
    $tipos = '';

    // Agregar condiciones para cada término de búsqueda
    foreach ($terminos as $termino) {
        $condiciones[] = "(p.idProducto LIKE ? OR p.codigo LIKE ? OR LOWER(p.producto) LIKE ? OR LOWER(c.categoria) LIKE ?)";
        $paramTerm = '%' . $termino . '%';
        $parametros[] = $paramTerm; // Para idProducto
        $parametros[] = $paramTerm; // Para codigo
        $parametros[] = $paramTerm; // Para producto
        $parametros[] = $paramTerm; // Para categoría
        $tipos .= 'ssss'; // Tipos para bind_param
    }

    // Construir el SQL con las condiciones dinámicas
    $sql = "SELECT p.idProducto, p.codigo, p.producto, p.precio, p.cantidad, p.imagen, c.categoria 
            FROM producto p
            LEFT JOIN productocategoria pc ON p.idProducto = pc.idProducto
            LEFT JOIN categoria c ON pc.idCategoria = c.idCategoria";

    // Añadir las condiciones de búsqueda si hay términos
    if (!empty($condiciones)) {
        $sql .= " WHERE " . implode(' AND ', $condiciones);
    }

    $stmt = $conexion->prepare($sql);

    // Verificar si hay parámetros antes de ejecutar
    if (!empty($parametros)) {
        $stmt->bind_param($tipos, ...$parametros);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();
    $listaProductos = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    Conecta::desConectaBD();

    return $listaProductos;
}
public function verificarProductoPorNombre($nombre)
{
    $conexion = Conecta::conectarBD();
    $sql = "SELECT COUNT(*) AS total FROM producto WHERE LOWER(TRIM(producto)) = LOWER(TRIM(?))";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $data = $resultado->fetch_assoc();
    $stmt->close();
    Conecta::desConectaBD();
    return $data['total'] > 0; // Retorna true si el producto existe, false si no
}
public function verificarProductoPorNombreEditar($nombre, $idProducto)
{
    $conexion = Conecta::conectarBD();
    $sql = "SELECT COUNT(*) AS total 
            FROM producto 
            WHERE LOWER(TRIM(producto)) = LOWER(TRIM(?)) 
            AND idProducto != ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $nombre, $idProducto); // "s" para string (nombre) y "i" para int (idProducto)
    $stmt->execute();
    $resultado = $stmt->get_result();
    $data = $resultado->fetch_assoc();
    $stmt->close();
    Conecta::desConectaBD();
    return $data['total'] > 0; // Retorna true si otro producto con el mismo nombre existe, false si no
}

public function crearProducto($codigo, $producto, $precio, $cantidad)
{
    $conexion = Conecta::conectarBD();
    $sql = "INSERT INTO producto (codigo, producto, precio, cantidad, imagen) VALUES (?, ?, ?, ?, 'prueba.png')";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ssds", $codigo, $producto, $precio, $cantidad);
    $resultado = $stmt->execute();

    if (!$resultado) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    $idProducto = $conexion->insert_id;
    $stmt->close();
    Conecta::desConectaBD();

    return $idProducto;
}

public function buscarProductoId($idProducto){
    $conexion = Conecta::conectarBD();
    $sql = "SELECT p.idProducto, p.codigo, p.producto, p.precio, p.cantidad, c.idCategoria, c.categoria
            FROM producto p
            JOIN productocategoria pc ON p.idProducto = pc.idProducto
            JOIN categoria c ON pc.idCategoria = c.idCategoria
            WHERE p.idProducto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();  // Convertimos el resultado en un array asociativo
    $stmt->close();
    Conecta::desConectaBD();
    return $producto;  // Devolvemos el array asociativo
}

public function crearCodigo() {
    $conexion = Conecta::conectarBD();
    // Obtener el último código generado en la base de datos para la categoría
    $sql = "SELECT codigo FROM producto WHERE codigo LIKE 'MUEB%' ORDER BY codigo DESC LIMIT 1;";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $ultimoCodigo = $resultado->fetch_assoc()['codigo'] ?? null;
    if ($ultimoCodigo) {
        $numero = (int)substr($ultimoCodigo, 4);
        $nuevoNumero = $numero + 1; // Incrementamos el número
    } else {

        $nuevoNumero = 1;
    }
    $codigoProducto= 'MUEB' . str_pad($nuevoNumero, 8, '0', STR_PAD_LEFT);
    Conecta::desConectaBD();
    return $codigoProducto;
}
public function actualizarProducto($idProducto, $producto,$precio, $cantidad){
    $conexion = Conecta::conectarBD();
    $sql = "UPDATE Producto SET producto = ?, precio = ?, cantidad = ? WHERE idProducto = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdii", $producto, $precio, $cantidad, $idProducto );
    $stmt->execute();
    $respuesta = $stmt->affected_rows > 0;
    $stmt->close();
    Conecta::desConectaBD();
    return $respuesta;
}

public function actualizarEstadoProducto($idProducto)
{
    $conexion = Conecta::conectarBD();
    $sql = "UPDATE producto SET estado = 'descontinuado' WHERE idProducto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i",  $idProducto);
    $stmt->execute();
    $respuesta = $stmt->affected_rows > 0;
    $stmt->close();
    Conecta::desConectaBD();
    return $respuesta;
}






    
    



}