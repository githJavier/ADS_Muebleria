<?php 
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formEmitirBoletaVenta{
    public function formEmitirBoletaVentaShow($listaDetalleProforma){
        $usuario = $_SESSION['usuario'];
        $listarprivilegios = $_SESSION['listarprivilegios'];
        $rol = $_SESSION['rol'];
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Emitir Boleta");
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
                            <h1 class="text-2xl font-bold">Emitir Boleta</h1>
                        </div>
                    </div>
                    <form action="./getBoleta.php" method="post">
                        <?php 
                        $proforma = $listaDetalleProforma[0]; // Ahora puedes acceder al primer elemento sin errores
                        ?>
                        <input type="text" name="txtIdProforma" value="<?php echo $proforma['idProforma']; ?>" class="hidden">
                        <!-- Tabla con bordes -->
                        <div class="overflow-hidden shadow-lg rounded-lg bg-white p-4 mb-6 mt-20">
                            <table class="min-w-full table-auto text-sm border-collapse">
                                <!-- Encabezado -->
                                <thead class="bg-neutral-800 text-white">
                                    <tr>
                                        <th class="py-2 px-4 text-left">Cantidad</th>
                                        <th class="py-2 px-4 text-left">Producto</th>
                                        <th class="py-2 px-4 text-left">Precio</th>
                                        <th class="py-2 px-4 text-left">Importe</th>
                                    </tr>
                                </thead>
                                <!-- Cuerpo -->
                                <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                    <?php 
                                        $totalProforma = 0;
                                        foreach ($listaDetalleProforma as $detalle) {
                                            $cantidad = $detalle['Cantidad'];
                                            $producto = $detalle['producto'];
                                            $precioUnitario = $detalle['precioUnitario'];
                                            $precioTotal = $detalle['PrecioTotal'];
                                            $totalProforma = $detalle['total'];
                                            $idProducto = $detalle['idProducto'];
                                    ?>
                                    <tr>
                                        <td class="py-2 px-4 text-left">
                                            <input type="hidden" name="cantidades[]" value="<?php echo $cantidad;?>">
                                            <?php echo $cantidad;?>
                                        </td>
                                        <td class="hidden">
                                            <input type="hidden" name="idProducto[]" value="<?php echo $idProducto; ?>">
                                        </td>
                                        <td class="py-2 px-4 text-left">
                                            <?php echo $producto;?>
                                        </td>
                                        <td class="py-2 px-4 text-left">
                                            <input type="hidden" name="preciosUnitarios[]" value="<?php echo $precioUnitario;?>">
                                            <?php echo $precioUnitario;?>
                                        </td>
                                        <td class="py-2 px-4 text-left">
                                            <?php echo $precioTotal;?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Total y botones -->
                        <div class="flex justify-end items-center mt-4">
                            <div class="mr-6">
                                <span class="text-white bg-neutral-800 px-4 py-2">Total</span>
                                <span class="text-black bg-white px-4 py-2 border border-gray-600">
                                <input type="hidden" name="totalProforma" value="<?php echo $totalProforma;?>">
                                    <?php echo $totalProforma;?>
                                </span>
                            </div>
                        </div>
                        <!-- Opciones de pago -->
                        <div class="flex justify-center items-center space-x-4 mt-6">
                            <label class="text-black flex items-center space-x-2">
                                <input type="radio" value="efectivo" class="accent-green-600" name="checkBoxPago">
                                <span class="text-black">Efectivo</span>
                            </label>
                            <label class="text-black flex items-center space-x-2">
                                <input type="radio" value="tarjeta" class="accent-green-600" name="checkBoxPago">
                                <span class="text-black">Tarjeta</span>
                            </label>
                        </div>                        
                        <!-- Botones de acción -->
                        <div class="flex justify-center mt-4 space-x-4">        
                            <button class="bg-neutral-800 text-white px-6 py-2 rounded-lg hover:bg-neutral-700" name="btnCancelar" type="submit">Cancelar</button>
                            <button class="bg-neutral-800 text-white px-6 py-2 rounded-lg hover:bg-neutral-700" name="btnProcesarPago" type="submit">Procesar Pago</button>                    
                        </div>
                    </form>
                </div>
            </div>
            <!-- Footer -->
            <?php $panelPrincipal->mostrarFooter(); ?>
        </body>

        <?php
    }
}

?>