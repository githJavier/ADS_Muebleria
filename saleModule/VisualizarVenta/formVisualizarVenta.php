<?php
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formVisualizarVenta {
    public function formVisualizarVentaShow($boleta) {
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
                    <div class="flex-1 bg-white p-8 ml-80 relative">
                        <!-- Barra fija -->
                        <div class="flex justify-between items-center gap-4 bg-neutral-100 px-4 py-6 shadow-md fixed top-0 left-80 right-0 z-10">
                            <div class="absolute left-0 right-0 flex justify-center">
                                <h1 class="text-2xl font-bold">Visualizar Venta</h1>
                            </div>
                        </div>

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
                                    <th class="py-2 px-4 text-left">Codigo</th>
                                    <th class="py-2 px-4 text-left">Estado</th>
                                    <th class="py-2 px-4 text-left">Monto</th>
                                    <th class="py-2 px-4 text-left">Fecha</th>
                                    <th class="py-2 px-4 text-left">Hora</th>
                                    <th class="py-2 px-4 text-left">Vendedor</th>
                                    <th class="py-2 px-4 text-left">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                <?php 
                                if ($boleta) {
                                    $idBoleta = $boleta['idBoleta'];
                                    $codigo = $boleta['numeroBoleta'];
                                    $estado = $boleta['estado'];
                                    $monto = $boleta['total'];
                                    $fecha = $boleta['fechaEmitida'];
                                    $hora = $boleta['horaEmitida'];
                                    $vendedor = $boleta['cajeroEmitida'];
                                ?>
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <td class="py-2 px-4 text-black" name="txtCodigo"><?php echo $codigo ?? null; ?></td>
                                    <td class="py-2 px-4 text-black" name="txtEstado"><?php echo $estado ?? null; ?></td>
                                    <td class="py-2 px-4 text-black" name="txtMonto"><?php echo $monto ?? null; ?></td>
                                    <td class="py-2 px-4 text-black" name="txtFecha"><?php echo $fecha ?? null; ?></td>
                                    <td class="py-2 px-4 text-black" name="txtHora"><?php echo $hora ?? null; ?></td>
                                    <td class="py-2 px-4 text-black" name="txtVendedor"><?php echo $vendedor ?? null; ?></td>
                                    <td class="py-2 px-4 text-black">
                                        <form action="./getVisualizarVenta.php" method="post">
                                            <input type="text" name="txtIdBoleta" value="<?php echo $idBoleta?>" class="hidden">
                                            <button class="bg-neutral-800 text-white py-1 px-4 rounded-md hover:bg-neutral-700" name="btnDetalleBoleta">detalle boleta</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
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
