<?php
class formAgregarProducto{
    public function formAgregarProductoShow($listaCategorias) {
        $usuario = $_SESSION['usuario'];
        $listarprivilegios = $_SESSION['listarprivilegios'];
        $rol = $_SESSION['rol'];
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Gestionar Producto");
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

                    <!-- Formulario con borde -->
                    <form method="POST" action="getGestionarProductos.php" enctype="multipart/form-data" class="space-y-6 mt-6">
                        <div class="border border-gray-300 border-b-2 border-b-gray-400 p-6">
                        
                            <div class="space-y-6">
                                <div class="flex justify-center">
                                    <div class="flex flex-col items-start">
                                        <label for="txtCodigo" class="block text-sm font-medium text-gray-700">
                                            Código del Producto
                                        </label>
                                        <input 
                                            name="txtCodigo"
                                            type="text" 
                                            class="mt-1 block w-[90%] border border-gray-300 border-b-2 border-gray-400 rounded-md shadow-sm focus:ring-custom focus:border-custom"
                                        />
                                    </div>
                                </div>

                                <div class="flex justify-center">
                                    <div class="flex flex-col items-start">
                                        <label for="txtProducto" class="block text-sm font-medium text-gray-700">
                                            Nombre del Producto
                                        </label>
                                        <input 
                                            name="txtProducto"
                                            type="text" 
                                            class="mt-1 block w-[90%] border border-gray-300 border-b-2 border-gray-400 rounded-md shadow-sm focus:ring-custom focus:border-custom"
                                        />
                                    </div>
                                </div>

                                <div class="flex justify-center">
                                    <div class="flex flex-col items-start">
                                        <label for="opcCategoria" class="block text-sm font-medium text-gray-700">
                                            Categoría
                                        </label>
                                        <select 
                                            name="opcCategoria"
                                            class="mt-1 block w-[90%] border border-gray-300 border-b-2 border-gray-400 rounded-md shadow-sm focus:ring-custom focus:border-custom"
                                        >
                                            <option value="">Seleccione una categoría</option>
                                            <?php foreach ($listaCategorias as $categoria) { ?>
                                                <option value="<?php echo $categoria['idCategoria']; ?>">
                                                    <?php echo $categoria['categoria']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-center">
                                    <div class="flex flex-col items-start">
                                        <label for="txtPrecio" class="block text-sm font-medium text-gray-700">Precio</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">S/</span>
                                            </div>
                                            <input
                                                id="txtPrecio"
                                                name="txtPrecio"
                                                type="text"
                                                class="pl-7 mt-1 block w-[90%] border border-gray-300 border-b-2 border-gray-400 rounded-md shadow-sm focus:ring-custom focus:border-custom"
                                                placeholder="0.00"
                                                onkeypress="validarNumeroConDecimal(event)"
                                                oninput="limpiarCaracteresNoValidos(this)"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-center">
                                    <div class="flex flex-col items-start">
                                        <label for="txtCantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                                        <input 
                                            name="txtCantidad" 
                                            id="txtCantidad" 
                                            type="text" 
                                            class="mt-1 block w-[90%] border border-gray-300 border-b-2 border-gray-400 rounded-md shadow-sm focus:ring-custom focus:border-custom" 
                                            onkeypress="return validarSoloNumeros(event)" 
                                            oninput="limpiarEntrada(this)" 
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center">                        
                                <button name="btnGestionarProducto" type="submit" class="!rounded-button inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                                    Cancelar
                                </button>                                    
                                <button name="btnCrearProducto" type="submit" class="!rounded-button inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-custom hover:bg-custom-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                                    Guardar Producto
                                </button>
                            </div>
                        
                        </div>
                    </form>
                </div>
            </div>
            <!-- Footer -->
            <?php $panelPrincipal->mostrarFooter(); ?>
            <script>
                // Permitir solo números en el campo
                function validarSoloNumeros(event) {
                    const charCode = event.which || event.keyCode;

                    // Permitir teclas numéricas (0-9), retroceso (Backspace), suprimir (Delete), tabulación (Tab)
                    if (
                        (charCode >= 48 && charCode <= 57) || // Números
                        charCode === 8 || // Retroceso
                        charCode === 9 // Tab
                    ) {
                        return true;
                    }

                    // Si no es un número, bloquear entrada
                    return false;
                }

                // Eliminar cualquier carácter no válido (en caso de que se peguen letras o caracteres no numéricos)
                function limpiarEntrada(input) {
                    input.value = input.value.replace(/[^0-9]/g, '');
                }

                // Función para validar solo números y un punto decimal
                function validarNumeroConDecimal(event) {
                    const charCode = event.which || event.keyCode;
                    const value = event.target.value;

                    // Permitir teclas numéricas (0-9), retroceso (Backspace), suprimir (Delete), tabulación (Tab) y un solo punto decimal
                    if (
                        (charCode >= 48 && charCode <= 57) || // Números
                        charCode === 8 || // Retroceso
                        charCode === 9 || // Tab
                        (charCode === 46 && value.indexOf('.') === -1) // Un solo punto decimal
                    ) {
                        return true;
                    }

                    // Si no es un número o punto decimal, bloquear entrada
                    return false;
                }

                // Función para limpiar caracteres no válidos si se pegan
                function limpiarCaracteresNoValidos(input) {
                    // Reemplazar cualquier cosa que no sea un número o un punto decimal
                    input.value = input.value.replace(/[^0-9.]/g, '');
                    
                    // Asegurarse de que solo haya un punto decimal
                    const parts = input.value.split('.');
                    if (parts.length > 2) {
                        input.value = parts[0] + '.' + parts[1];
                    }
                }
            </script>
        </body>
        <?php
    }
}
?>
