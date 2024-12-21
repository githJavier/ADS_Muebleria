<?php 
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");
 class formGestionarProducto{
    public function formGestionarProductoShow($listaProductos){
        $usuario = $_SESSION['usuario'];
        $listarprivilegios = $_SESSION['listarprivilegios'];
        $rol = $_SESSION['rol'];
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Gestionar Productos");
        $panelPrincipal = new PanelPrincipalUsuario;
        ?>
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
                            <h1 class="text-2xl font-bold">Gestionar Productos</h1>
                        </div>
                    </div>
                    <form action="getGestionarProductos.php" method="POST">
                        <div class="mb-6 mt-24 flex justify-between gap-8">
                            <!-- Contenedor para el input de búsqueda y botón de búsqueda pegado a la izquierda -->
                            <div class="flex gap-4 items-center w-full">
                                <input type="text" id="search-input" class="bg-white border border-black text-black rounded-md p-2 w-48" name="txtBuscarProducto" placeholder="Buscar producto...">
                                <button class="bg-neutral-800 text-white font-bold py-2 px-6 rounded-md hover:bg-neutral-700" type="submit" name="btnBuscarProducto">Buscar</button>
                            </div>
                            <!-- Botones para acciones alineados a la derecha -->
                            <div class="flex gap-4 justify-end w-full">
                                <button class="py-1 px-2 font-bold bg-neutral-800 text-white rounded-md hover:bg-neutral-700 transition" name="btnAgregarProducto">Agregar Producto</button>
                            </div>
                        </div>
                    </form>
                    <!-- Tabla de productos -->
                    <div class="">
                        <table border="1" id="product-table" class="min-w-full table-auto text-sm">                                    
                            <thead class="border-b-2">
                                <tr class="bg-neutral-800 text-white">
                                    <th scope="col" class="py-2 px-4 text-left text-sm">Código</th>
                                    <th scope="col" class="py-2 px-4 text-left text-sm">Producto</th>
                                    <th scope="col" class="py-2 px-4 text-left text-sm">Categoría</th>
                                    <th scope="col" class="py-2 px-4 text-left text-sm">Precio</th>
                                    <th scope="col" class="py-2 px-4 text-left text-sm">Cantidad</th>
                                    <th scope="col" class="py-2 px-4 text-left text-sm">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                <?php foreach ($listaProductos as $producto) { ?>                                       
                                    <tr>
                                        <td class="py-2 px-4 text-black text-sm">
                                            <?php echo $producto['codigo']; ?>
                                        </td>
                                        <td class="py-2 px-4 text-black text-sm">
                                            <div class="flex items-center">                                                    
                                                <div class="">                                                        
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo $producto['producto']; ?>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </td>
                                        <td class="py-2 px-4 text-black text-sm">
                                            <?php echo $producto['categoria'] ?: 'Sin categoría'; ?>
                                        </td>
                                        <td class="py-2 px-4 text-black text-sm">
                                            <?php echo $producto['precio']; ?>
                                        </td>                                            
                                        <td class="py-2 px-4 text-black text-sm">
                                            <?php echo $producto['cantidad']; ?>
                                        </td>
                                        <td class="py-2 px-4 text-black text-sm">
                                            <div class="flex space-x-4">
                                                <!-- Botón Editar -->
                                                <form action="getGestionarProductos.php" method="post">
                                                    <button type="submit" class="bg-neutral-800 text-white px-3 py-2 rounded hover:bg-neutral-700" name="btnEditar" value="<?php echo $producto['idProducto']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </form action="getGestionarProductos.php" method="post">
                                                <!-- Botón Eliminar -->
                                                <form action="getGestionarProductos.php" method="post">
                                                    <button class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600" name="btnEliminar" value="<?php echo $producto['idProducto']?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>                   
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>     
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php $panelPrincipal->mostrarFooter(); ?>
        </body>
        <?php
    }
 }
?>