<?php
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formEmitirProforma {
    public function formEmitirProformaShow($listaProductos) {
        $usuario = $_SESSION['usuario'];
        $listarprivilegios = $_SESSION['listarprivilegios'];
        $rol = $_SESSION['rol'];
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Emitir Proforma");
        $panelPrincipal = new PanelPrincipalUsuario;
        ?>
        <html>
            <body class="bg-white text-gray-900 flex flex-col min-h-screen">
                <div class="flex">
                    <!-- Panel lateral fijo -->
                    <div class="w-80 bg-neutral-800 p-6 flex flex-col justify-between shadow-lg fixed h-full">
                        <div>
                            <?php $panelPrincipal->perfilUsuario($usuario, $rol, $listarprivilegios); ?>
                        </div>
                        <?php $panelPrincipal->formCerrarSesion("../../securityModule/cerrarSesion.php"); ?>
                    </div>

                    <!-- Contenido principal -->
                    <div class="flex-1 bg-white p-8 ml-80 relative">
                        <!-- Barra fija -->
                        <div class="flex justify-between items-center gap-4 bg-neutral-100 px-4 py-6 shadow-md fixed top-0 left-80 right-0 z-10">
                            <div class="absolute left-0 right-0 flex justify-center">
                                <h1 class="text-2xl font-bold">Emitir Proforma</h1>
                            </div>
                        </div>

                        <!-- Espaciado para evitar solapamiento con la barra fija -->
                        <div class="mt-24 flex justify-between gap-8">
                            <!-- Contenedor para el input de búsqueda y botón de búsqueda pegado a la izquierda -->
                            <form id="searchForm" method="POST" class="flex gap-4 items-center w-full">
                                <div>
                                    <input type="text" id="search-input" class="p-3 border rounded-md w-1/2" placeholder="Buscar producto...">
                                    <button class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition" name="btnBuscarProducto">Buscar</button>
                                </div>
                            </form>
                            <!-- Botones para acciones alineados a la derecha -->
                            <div class="flex gap-4 justify-end w-full">
                                <button onclick="toggleModal()" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition">Productos Seleccionados</button>
                            </div>
                        </div>

                        <!-- Espaciado para las tablas -->
                        <div class="mt-8 flex gap-8 justify-center">
                            <div class="flex-1 w-3/4" id="productTableContainer" <?php echo empty($listaProductos) ? 'style="display: none;"' : ''; ?> >
                                <?php if (!empty($listaProductos)) { ?>
                                    <?php $this->tableProducto($listaProductos); ?>
                                <?php } else { ?>
                                    <p>No hay productos disponibles.</p>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Modal para ver la lista de productos seleccionados -->
                <div id="productModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-20 hidden">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative">
                        <h3 class="text-xl font-bold mb-4 text-center">Lista de Productos Seleccionados</h3>
                        <table border="1" id="product-list" class="w-full mb-4 text-center border border-gray-300">
                            <thead id="product-list-header">
                                <!-- El encabezado solo se mostrará si hay productos -->
                            </thead>
                            <tbody id="product-list-body">
                                <!-- Aquí se mostrarán los productos seleccionados -->
                            </tbody>
                        </table>
                        <!-- Botones dentro del modal -->
                        <div class="flex gap-4 mt-4 justify-between">
                            <button onclick="discardList()" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition w-1/2">Descartar Lista</button>
                            <button onclick="generateProforma()" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition w-1/2">Generar Proforma</button>
                        </div>
                        
                        <!-- X para cerrar el modal -->
                        <button onclick="toggleModal()" class="absolute top-2 right-2 text-xl text-neutral-800 hover:text-red-500">×</button>
                    </div>
                </div>

                <!-- Modal si no hay productos -->
                <div id="noProductsModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-20 hidden">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative">
                        <h3 class="text-xl font-bold mb-4 text-center">No hay productos seleccionados</h3>
                        <p class="text-center">Por favor, agrega productos antes de proceder.</p>
                        <div class="flex gap-4 mt-4 justify-center">
                            <button onclick="closeNoProductsModal()" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition w-1/2">Cerrar</button>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <?php $panelPrincipal->mostrarFooter(); ?>

                <script src="../../asset/js/emitirProforma.js"></script>
            </body>
        </html>
        <?php
    }

    public function tableProducto($listaProductos) {
        ?>
        <table border="1" id="product-table" class="w-full mx-auto text-center border border-gray-300">
            <thead>
                <tr>
                    <th class="p-3">Código</th>
                    <th class="p-3">Producto</th>
                    <th class="p-3">Precio</th>
                    <th class="p-3">Cantidad</th>
                    <th class="p-3">Acción</th>
                    <th class="p-3">Imagen</th>
                </tr>
            </thead>
            <tbody id="product-body">
                <?php 
                foreach ($listaProductos as $producto) {
                    $idProducto = $producto['idProducto'];
                    $codigo = $producto['codigo'];
                    $nombre = $producto['producto'];
                    $precio = $producto['precio'];
                    $cantidad = $producto['cantidad'];
                    $imagen = $producto['imagen'];
                ?>
                <tr>
                    <td class="p-3"><?php echo $codigo ?></td>
                    <td class="p-3"><?php echo $nombre ?></td>
                    <td class="p-3"><?php echo $precio ?></td>
                    <td class="p-3">
                        <button class="decrease" onclick="updateQuantity(event, <?php echo $idProducto ?>, <?php echo $cantidad ?>)">-</button>
                        <input type="text" id="quantity-<?php echo $idProducto ?>" value="<?php echo ($cantidad > 0) ? 1 : 'Agotado'; ?>" readonly class="w-16 text-center <?php echo ($cantidad == 0) ? 'bg-gray-300' : ''; ?>">
                        <button class="increase" onclick="updateQuantity(event, <?php echo $idProducto ?>, <?php echo $cantidad ?>)">+</button>
                    </td>
                    <td class="p-3"><img src="<?php echo $imagen ?>" width="50"></td>
                    <td class="p-3">
                        <button onclick="addProductToList(event, '<?php echo $idProducto ?>', '<?php echo $codigo ?>', '<?php echo $nombre ?>', <?php echo $precio ?>)" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700">Agregar</button>
                    </td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
        <?php
    }
}
?>
