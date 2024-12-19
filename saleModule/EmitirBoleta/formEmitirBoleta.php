<?php 
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formEmitirBoleta{
    public function formEmitirBoletaShow($listaProfomas){
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
                    <!-- Formulario -->
                    <form action="./getBoleta.php" method="post">
                        <div class="flex items-center justify-center mb-6 mt-24">
                            <label for="numeroProforma" class="mr-4">N° de Proforma:</label>
                            <input type="text" id="numeroProforma" name="txtCodigoProforma" class="bg-white border border-black text-black rounded-md p-2 w-48" placeholder="Ingrese N° de Proforma">
                            <button class="ml-4 bg-neutral-800 text-white font-bold py-2 px-6 rounded-md hover:bg-neutral-700" name="btnBuscarProforma">Buscar Proforma</button>
                        </div>
                    </form>

                    <!-- Tabla con bordes -->
                    <div class="overflow-hidden shadow-lg rounded-lg bg-white p-4 mb-6">
                        <table class="min-w-full table-auto text-sm border-collapse">
                            <thead>
                                <tr class="bg-neutral-800 text-white">
                                    <th class="py-2 px-4 text-left">N° Proforma</th>
                                    <th class="py-2 px-4 text-left">Fecha Emitida</th>
                                    <th class="py-2 px-4 text-left">Hora Emitida</th>
                                    <th class="py-2 px-4 text-left">Monto</th>
                                    <th class="py-2 px-4 text-left">Estado</th>
                                    <th class="py-2 px-4 text-left">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                <?php 
                                foreach ($listaProfomas as $proforma) {
                                    $numeroProforma = $proforma['numeroProforma'];
                                    $fechaEmitida = $proforma['fechaEmitida'];
                                    $horaEmitida = $proforma['horaEmitida'];
                                    $monto = $proforma['total'];
                                    $estado = $proforma['estado'];
                                    $idProforma = $proforma['idProforma']
                                ?>
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <td class="py-2 px-4 text-black"><?php echo $numeroProforma; ?></td>
                                    <td class="py-2 px-4 text-black"><?php echo $fechaEmitida; ?></td>
                                    <td class="py-2 px-4 text-black"><?php echo $horaEmitida; ?></td>
                                    <td class="py-2 px-4 text-black"><?php echo $monto; ?></td>
                                    <td class="py-2 px-4 text-black"><?php echo $estado; ?></td>
                                    <td class="py-2 px-4 text-black">
                                        <form action="./getBoleta.php" method="post">
                                            <input type="text" name="txtIdProforma" value="<?php echo $idProforma?>" class="hidden">
                                            <button class="bg-neutral-800 text-white py-1 px-4 rounded-md hover:bg-neutral-700" name="btnVerBoleta">Ver</button>
                                        </form>
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
