<?php
include '../../shared/renderHeader.php';
include '../../securityModule/panelPrincipalUsuario.php';

class formAgregarUsuario {
    public function formAgregarUsuarioShow($roles, $privilegios){
        include 'sessionManager.php';

        $objCabecera = new renderHeader();
        $objCabecera->cabeceraShow("Agregar Usuario");
        $panelPrincipal = new PanelPrincipalUsuario;

        ?>
        <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8">
                <h1 class="text-2xl font-bold text-gray-900 text-center mb-8">Registro de Nuevo Usuario</h1>
                
                <form method="POST" action="getGUP.php" class="space-y-8">
                    <div class="space-y-8 divide-y divide-gray-200">
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900">Datos Personales</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="txtNombre" class="block text-sm font-medium text-gray-700">Primer Nombre</label>
                                    <div class="mt-1">
                                        <input type="text" required="" 
                                        id="txtNombre" 
                                        name="txtNombre"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                                <div>
                                    <label for="txtApellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                                    <div class="mt-1">
                                        <input type="text" required="" 
                                        id="txtApellido" 
                                        name="txtApellido"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                                <div>
                                    <label for="txtCorreo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                    <div class="mt-1">
                                        <input type="email" required="" 
                                        id="txtCorreo" 
                                        name="txtCorreo"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                                <div>
                                    <label for="txtTelefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                    <div class="mt-1">
                                        <input type="number" required="" 
                                        id="txtTelefono" 
                                        name="txtTelefono"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-8 space-y-6">
                            <h3 class="text-lg font-medium text-gray-900">Datos de Cuenta</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="txtUsuario" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                                    <div class="mt-1">
                                        <input type="text" required="" 
                                        id="txtUsuario" 
                                        name="txtUsuario"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                                <div>
                                    <label for="txtClave" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <div class="mt-1">
                                        <input type="password" required="" 
                                        id="txtClave" 
                                        name="txtClave"
                                        lass="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                                <div>
                                    <label for="checkEstado" class="block text-sm font-medium text-gray-700">Estado del Usuario</label>
                                    
                                    <div class="mt-1 flex items-center">
                                        <input type="checkbox"
                                        id="checkEstado"
                                        name="checkEstado"
                                        class="h-4 w-4 text-custom focus:ring-custom border-gray-300 !rounded" />
                                        <label class="ml-3 text-sm text-gray-700">Usuario Habilitado</label>
                                    </div>
                                </div>
                                <div>
                                    <label for="textPregunta"  class="block text-sm font-medium text-gray-700">Pregunta de Seguridad</label>
                                    <div class="mt-1">
                                        <input type="text" required="" 
                                        id="textPregunta" 
                                        name="textPregunta"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="textRespuesta" class="block text-sm font-medium text-gray-700">Respuesta de Seguridad</label>
                                    <div class="mt-1">
                                        <input type="text" required="" 
                                        id="textRespuesta" 
                                        name="textRespuesta"
                                        class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-8 space-y-6">
                            <h3 class="text-lg font-medium text-gray-900">Rol y Privilegios</h3>
                            <div class="space-y-6">
                                <!-- Roles -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Rol</label>
                                    <div class="mt-4 space-y-4">
                                        <?php foreach ($roles as $rol): ?>
                                            <div class="flex items-center">
                                                <input type="checkbox" name="roles[]" value="<?php echo $rol['idRol']; ?>" class="h-4 w-4 text-custom focus:ring-custom border-gray-300 !rounded">
                                                <label class="ml-3 text-sm text-gray-700"><?php echo htmlspecialchars($rol['nombre_rol']); ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Privilegios -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-4">Privilegios</label>
                                    <div class="space-y-4">
                                        <?php foreach ($privilegios as $privilegio): ?>
                                            <div class="flex items-center">
                                                <input type="checkbox" name="privilegios[]" value="<?php echo $privilegio['idPrivilegio']; ?>" class="h-4 w-4 text-custom focus:ring-custom border-gray-300 !rounded">
                                                <label class="ml-3 text-sm text-gray-700"><?php echo htmlspecialchars($privilegio['labelPrivilegio']); ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="reset" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium !rounded-button text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                            <i class="fas fa-eraser mr-2"></i>
                            Limpiar
                        </button>
                        
                        
                        <button name="btnCrearUsuario" type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium !rounded-button text-white bg-custom hover:bg-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                        <i class="fas fa-save mr-2"></i>
                        Guardar
                    </button>
                    
                </div>
            </form>
            <form method="POST" action="getGUP.php">
                <button name="btnGUP" type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium !rounded-button text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
            </form>
            </div>
        </main>


        <?php
    }
}
?>