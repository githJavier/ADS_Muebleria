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
                        <div class="mb-6 mt-24 flex justify-between gap-8">
                            <!-- Contenedor para el input de búsqueda y botón de búsqueda pegado a la izquierda -->
                            <form action="getProforma.php" method="POST">
                                <div class="flex gap-4 items-center w-full">
                                    <input type="text" id="search-input" class="bg-white border border-black text-black rounded-md p-2 w-48" name="txtBuscarProducto" placeholder="Buscar producto...">
                                    <button class="bg-neutral-800 text-white font-bold py-2 px-6 rounded-md hover:bg-neutral-700" type="submit" name="btnBuscarProducto">Buscar</button>
                                </div>
                            </form>
                            <!-- Botones para acciones alineados a la derecha -->
                            <div class="flex gap-4 justify-end w-full">
                                <button onclick="toggleModal()" class="py-1 px-2 font-bold bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition">Productos Seleccionados</button>
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
                <form id="proformaForm" method="post" action="getProforma.php">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative">
                        <h3 class="text-xl font-bold mb-4 text-center">Lista de Productos Seleccionados</h3>
                        <table border="1" id="product-list" class="w-full mb-4 text-center border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="p-3">Código</th>
                                    <th class="p-3">Producto</th>
                                    <th class="p-3">Precio</th>
                                    <th class="p-3">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="product-list-body">
                                <!-- Aquí se mostrarán los productos seleccionados -->
                            </tbody>
                        </table>
                        <!-- Botones dentro del modal -->
                        <div class="flex gap-4 mt-4 justify-between">
                            <button type="button" onclick="discardList()" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition w-1/2">Descartar Lista</button>
                            <button type="submit" class="p-3 bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition w-1/2" name="btnGenerarProforma">Generar Proforma</button>
                        </div>
                        <!-- Campo oculto para los productos seleccionados -->
                        <input type="hidden" name="selectedProducts" id="selectedProductsInput">
                        <!-- Botón para cerrar el modal -->
                        <button type="button" onclick="toggleModal()" class="absolute top-2 right-2 text-xl text-neutral-800 hover:text-red-500">×</button>
                    </div>
                </form>

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
        <table border="1" id="product-table" class="min-w-full table-auto text-sm">
            <thead class="border-b-2">
                <tr class="bg-neutral-800 text-white">
                    <th class="py-2 px-4 text-left text-sm">Código</th>
                    <th class="py-2 px-4 text-left text-sm">Producto</th>
                    <th class="py-2 px-4 text-left text-sm">Precio</th>
                    <th class="py-2 px-4 text-left text-sm">Cantidad</th>
                    <th class="py-2 px-4 text-left text-sm">Imagen</th>
                    <th class="py-2 px-4 text-left text-sm">Acción</th>
                </tr>
            </thead>
            <tbody id="product-body" class="border border-gray-300 border-b-2 border-b-gray-400">
                <?php 
                foreach ($listaProductos as $producto) {
                    $idProducto = $producto['idProducto'];
                    $codigo = $producto['codigo'];
                    $nombre = $producto['producto'];
                    $precio = $producto['precio'];
                    $cantidad = $producto['cantidad'];
                    $imagen = $producto['imagen'];
                ?>
                <tr class="">
                    <td class="py-2 px-4 text-black text-sm"><?php echo $codigo ?></td>
                    <td class="py-2 px-4 text-black text-sm"><?php echo $nombre ?></td>
                    <td class="py-2 px-4 text-black text-sm"><?php echo $precio ?></td>
                    <td class="py-2 px-4 text-black text-sm">
                        <button class="decrease bg-neutral-800 text-white py-2 px-4 rounded-md hover:bg-neutral-700" onclick="updateQuantity(event, <?php echo $idProducto ?>, <?php echo $cantidad ?>)">-</button>
                        <input type="text" id="quantity-<?php echo $idProducto ?>" value="<?php echo ($cantidad > 0) ? 1 : 'Agotado'; ?>" readonly class="py-1 px-4 rounded-md w-16 text-center <?php echo ($cantidad == 0) ? 'bg-gray-300' : ''; ?>">
                        <button class="increase bg-neutral-800 text-white py-2 px-4 rounded-md hover:bg-neutral-700" onclick="updateQuantity(event, <?php echo $idProducto ?>, <?php echo $cantidad ?>)">+</button>
                    </td>
                    <td class="py-2 px-4 text-black text-sm"><img src="<?php echo $imagen ?>" width="50"></td>
                    <td class="py-2 px-4 text-black text-sm">
                        <button onclick="addProductToList(event, '<?php echo $idProducto ?>', '<?php echo $codigo ?>', '<?php echo $nombre ?>', <?php echo $precio ?>)" class="bg-neutral-800 text-white py-2 px-4 rounded-md hover:bg-neutral-700">Agregar</button>
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