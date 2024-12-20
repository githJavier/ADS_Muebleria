<?php
include '../../shared/renderHeader.php';
include '../../securityModule/panelPrincipalUsuario.php';

class formEditarUsuario {
    public function formEditarUsuarioShow($usuario, $roles, $privilegios, $rolesAsignados, $privilegiosAsignados) {
        include 'sessionManager.php';

        $objCabecera = new renderHeader();
        $objCabecera->cabeceraShow("Editar Usuario");
        $panelPrincipal = new PanelPrincipalUsuario;

        ?>

        <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8">
                <h1 class="text-2xl font-bold text-gray-900 text-center mb-8">Editar Usuario</h1>
                
                <form method="POST" action="getGUP.php" class="space-y-8">
                    <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>">

                    <!-- Datos Personales -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Datos Personales</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="txtNombre" class="block text-sm font-medium text-gray-700">Primer Nombre</label>
                                <input type="text" id="txtNombre" name="txtNombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                            <div>
                                <label for="txtApellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                                <input type="text" id="txtApellido" name="txtApellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                            <div>
                                <label for="txtCorreo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input type="email" id="txtCorreo" name="txtCorreo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                            <div>
                                <label for="txtTelefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="number" id="txtTelefono" name="txtTelefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                        </div>
                    </div>

                    <!-- Datos de Cuenta -->
                    <div class="pt-8 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Datos de Cuenta</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="txtUsuario" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                                <input type="text" id="txtUsuario" name="txtUsuario" value="<?php echo htmlspecialchars($usuario['nombreUsuario']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                            <div>
                                <label for="txtClave" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input type="password" id="txtClave" name="txtClave" class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                            <div>
                                <label for="checkEstado" class="block text-sm font-medium text-gray-700">Estado del Usuario</label>
                                <div class="mt-1 flex items-center">
                                    <input type="checkbox" id="checkEstado" name="checkEstado" <?php echo $usuario['estado'] == 1 ? 'checked' : ''; ?> class="h-4 w-4 text-custom focus:ring-custom border-gray-300 !rounded">
                                    <label class="ml-3 text-sm text-gray-700">Usuario Habilitado</label>
                                </div>
                            </div>
                            <div>
                                <label for="textPregunta" class="block text-sm font-medium text-gray-700">Pregunta de Seguridad</label>
                                <input type="text" id="textPregunta" name="textPregunta" value="<?php echo htmlspecialchars($usuario['preguntaSeguridad']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                            <div>
                                <label for="textRespuesta" class="block text-sm font-medium text-gray-700">Respuesta de Seguridad</label>
                                <input type="text" id="textRespuesta" name="textRespuesta" value="<?php echo htmlspecialchars($usuario['respuestaSeguridad']); ?>" required class="shadow-sm focus:ring-custom focus:border-custom block w-full sm:text-sm border-gray-300 !rounded-button">
                            </div>
                        </div>
                    </div>

                    <!-- Roles y Privilegios -->
                    <div class="pt-8 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Rol y Privilegios</h3>

                        <!-- Roles -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rol</label>
                            <div class="mt-4 space-y-4">
                                <?php foreach ($roles as $rol): ?>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="roles[]" value="<?php echo $rol['idRol']; ?>" <?php echo in_array($rol['idRol'], $rolesAsignados) ? 'checked' : ''; ?> class="h-4 w-4 text-custom focus:ring-custom border-gray-300 !rounded">
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
                                        <input type="checkbox" name="privilegios[]" value="<?php echo $privilegio['idPrivilegio']; ?>" <?php echo in_array($privilegio['idPrivilegio'], $privilegiosAsignados) ? 'checked' : ''; ?> class="h-4 w-4 text-custom focus:ring-custom border-gray-300 !rounded">
                                        <label class="ml-3 text-sm text-gray-700"><?php echo htmlspecialchars($privilegio['labelPrivilegio']); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4">
                        <button name="btnActualizarUsuario" type="submit" class="inline-flex items-center px-4 py-2 bg-custom text-white font-medium !rounded-button hover:bg-red-600">
                            <i class="fas fa-save mr-2"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php
    }
}
?>
