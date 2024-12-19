<?php 
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formVerBoleta{
    public function formVerBoletaShow($listaDetalleBoleta){
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
                    <!-- Información del cajero y transacción -->
                    <div class="mb-4 mt-10">
                        <?php $detalle = $listaDetalleBoleta[0];?>
                        <p><span class="font-semibold">Numero de boleta:</span> <?php echo $detalle['numeroBoleta']?></p>
                        <p><span class="font-semibold">Cajero:</span> <?php echo $detalle['cajeroEmitida']?></p>
                        <p><span class="font-semibold">Método de pago:</span> <?php echo $detalle['tipo']?></p>
                        <p><span class="font-semibold">Hora de transacción:</span> <?php echo $detalle['horaEmitida']?></p>
                        <p><span class="font-semibold">Fecha de emisión:</span> <?php echo $detalle['fechaEmitida']?></p>
                    </div>
                    <!-- Tabla de productos -->
                    <div class="overflow-hidden bg-white p-4 mb-6 mt-20">
                        <table class="min-w-full table-auto text-sm border-collapse">
                            <thead class="bg-neutral-800 text-white">
                                <tr>
                                    <th class="py-2 px-4 text-left">Cantidad</th>
                                    <th class="py-2 px-4 text-left">Producto</th>
                                    <th class="py-2 px-4 text-left">Precio Unitario</th>
                                    <th class="py-2 px-4 text-left">Importe</th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                <?php 
                                    foreach($listaDetalleBoleta as $detalle){
                                        $producto = $detalle['producto'];
                                        $cantidad = $detalle['cantidad'];
                                        $precioUnitario = $detalle['precioUnitario'];
                                        $precioTotal = $detalle['precioTotal'];
                                    
                                ?>
                                <tr>
                                    <td class="py-2 px-4"><?php echo $cantidad;?></td>
                                    <td class="py-2 px-4"><?php echo $producto;?></td>
                                    <td class="py-2 px-4"><?php echo $precioUnitario;?></td>
                                    <td class="py-2 px-4"><?php echo $precioTotal;?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Total -->
                    <div class="flex justify-end items-center mb-4">
                        <span class="bg-neutral-800 text-white px-4 py-2 mr-2">Subtotal</span>
                        <span class="bg-white text-black px-4 py-2 border border-gray-600"><?php echo $detalle['subtotal']?></span>
                    </div>
                    <div class="flex justify-end items-center mb-4">
                        <span class="bg-neutral-800 text-white px-4 py-2 mr-2">Impuesto</span>
                        <span class="bg-white text-black px-4 py-2 border border-gray-600"><?php echo $detalle['impuesto']?></span>
                    </div>
                    <div class="flex justify-end items-center mb-4">
                        <span class="bg-neutral-800 text-white px-4 py-2 mr-2">Total</span>
                        <span class="bg-white text-black px-4 py-2 border border-gray-600"><?php echo $detalle['total']?></span>
                    </div>
                    <!-- Botón de acción -->
                    <div class="text-center">
                        <button class="bg-neutral-800 hover:bg-neutral-700 text-white px-6 py-2 rounded-lg hover:bg-green-500 transition">Imprimir Boleta</button>
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