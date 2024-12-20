<?php 
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formVerDetalleBoleta {
    public function formVerDetalleBoletaShow($detalle_boleta) {
        $usuario = $_SESSION['usuario'];
        $listarprivilegios = $_SESSION['listarprivilegios'];
        $rol = $_SESSION['rol'];
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Visualizar Venta");
        $panelPrincipal = new PanelPrincipalUsuario;
        ?>
        <html>
            <body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">
                <div class="flex">
                    <!-- Panel lateral fijo -->
                    <div class="w-80 bg-neutral-800 p-6 flex flex-col justify-between shadow-lg fixed h-full">
                        <div>
                            <?php $panelPrincipal->perfilUsuario($usuario, $rol, $listarprivilegios); ?>
                        </div>
                        <?php $panelPrincipal->formCerrarSesion("../../securityModule/cerrarSesion.php"); ?>
                    </div>

                    <!-- Contenido principal -->
                    <div class="flex-1 bg-white p-8 ml-80">
                        <!-- Barra fija -->
                        <div class="flex justify-between items-center gap-4 bg-neutral-100 px-4 py-6 shadow-md fixed top-0 left-80 right-0 z-10">
                            <div class="absolute left-0 right-0 flex justify-center">
                                <h1 class="text-2xl font-bold">Visualizar Venta</h1>
                            </div>
                        </div>

                        <!-- Formulario de búsqueda -->
                        <form action="./getVisualizarVenta.php" method="post">
                            <div class="flex items-center justify-center mb-6 mt-24">
                                <label for="numeroProforma" class="mr-4">N° de Boleta:</label>
                                <input type="text" id="numeroProforma" name="txtCodigoBoleta" class="bg-white border border-black text-black rounded-md p-2 w-48" placeholder="Ingrese N° de Boleta">
                                <button class="ml-4 bg-neutral-800 text-white font-bold py-2 px-6 rounded-md hover:bg-neutral-700" name="btnBuscarBoleta">Buscar Boleta</button>
                            </div>
                        </form>

                        <!-- Tabla de resultados -->
                        <table class="min-w-full table-auto text-sm border-collapse">
                            <thead>
                                <tr class="bg-neutral-800 text-white">
                                    <th class="py-2 px-4 text-left">Código</th>
                                    <th class="py-2 px-4 text-left">Estado</th>
                                    <th class="py-2 px-4 text-left">Monto</th>
                                    <th class="py-2 px-4 text-left">Fecha</th>
                                    <th class="py-2 px-4 text-left">Hora</th>
                                    <th class="py-2 px-4 text-left">Vendedor</th>
                                    <th class="py-2 px-4 text-left">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                <?php 
                                if ($detalle_boleta && isset($detalle_boleta[0])) {
                                    $idBoleta = $detalle_boleta[0]['idBoleta'];
                                    $codigo = $detalle_boleta[0]['numeroBoleta'];
                                    $estado = $detalle_boleta[0]['estado'];
                                    $monto = $detalle_boleta[0]['total'];
                                    $fecha = $detalle_boleta[0]['fechaEmitida'];
                                    $hora = $detalle_boleta[0]['horaEmitida'];
                                    $vendedor = $detalle_boleta[0]['cajeroEmitida'];
                                ?>
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <td class="py-2 px-4"><?php echo $codigo ?? null; ?></td>
                                    <td class="py-2 px-4"><?php echo $estado ?? null; ?></td>
                                    <td class="py-2 px-4"><?php echo $monto ?? null; ?></td>
                                    <td class="py-2 px-4"><?php echo $fecha ?? null; ?></td>
                                    <td class="py-2 px-4"><?php echo $hora ?? null; ?></td>
                                    <td class="py-2 px-4"><?php echo $vendedor ?? null; ?></td>
                                    <td class="py-2 px-4">
                                        <form action="./getVisualizarVenta.php" method="post">
                                            <input type="hidden" name="txtIdBoleta" value="<?php echo $idBoleta?>">
                                            <button class="bg-neutral-800 text-white py-1 px-4 rounded-md hover:bg-neutral-700" name="btnDetalleBoleta">Ver Detalles</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Tabla de detalle de boleta -->
                        <h2 class="text-xl font-bold mb-4">Detalle de la Boleta</h2>
                        <table class="min-w-full table-auto text-sm border border-gray-300">
                            <thead>
                                <tr class="bg-neutral-800 text-white">
                                    <th class="py-2 px-4 text-left">Código</th>
                                    <th class="py-2 px-4 text-left">Producto</th>
                                    <th class="py-2 px-4 text-left">Precio Unitario</th>
                                    <th class="py-2 px-4 text-left">Precio Total</th>
                                    <th class="py-2 px-4 text-left">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($detalle_boleta as $detalle){?>
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <td class="py-2 px-4"><?php echo $detalle['codigo']?></td>
                                    <td class="py-2 px-4"><?php echo $detalle['producto']?></td>
                                    <td class="py-2 px-4"><?php echo $detalle['precioUnitario']?></td>
                                    <td class="py-2 px-4"><?php echo $detalle['precioTotal']?></td>
                                    <td class="py-2 px-4"><?php echo $detalle['cantidad']?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <!-- Botón para entregar productos -->
                        <form action="./getVisualizarVenta.php" method="post">
                            <div class="flex justify-end mt-6">
                                <input type="hidden" name="txtIdBoletaEstado" value="<?php echo $detalle_boleta[0]['idBoleta']?>">
                                <button class="bg-neutral-800 text-white font-bold py-2 px-6 rounded-md hover:bg-neutral-700" name="btnDespacharBoleta">Despachar Boleta</button>
                            </div>            
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <?php $panelPrincipal->mostrarFooter(); ?>
            </body>
        </html>
        <?php
    }
}
?>
