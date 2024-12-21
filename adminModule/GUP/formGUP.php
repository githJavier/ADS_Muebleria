<?php
include_once("../../shared/renderHeader.php");
include_once("../../securityModule/panelPrincipalUsuario.php");

class formGUP {
    public function formGUPShow($listaUsuarios) {
        session_start();
        $usuario = $_SESSION['usuario'];
        $listarprivilegios = $_SESSION['listarprivilegios'];
        $rol = $_SESSION['rol'];
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Gestionar Usuarios");
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
                            <h1 class="text-2xl font-bold">Gestionar Usuarios</h1>
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50 min-h-screen">
                        <div class="flex justify-end items-center mb-4 mt-20">
                            <form method="POST" action="getGUP.php">
                                <button 
                                name="btnAgregarUsuario" value="btnAgregarUsuario"
                                class="bg-neutral-800 text-white px-4 py-2 rounded hover:bg-neutral-700">
                                    <i class="fas fa-user-plus mr-2"></i> Agregar Usuario
                                </button>
                            </form>
                        </div>
                        <div class="bg-white shadow-lg overflow-hidden">
                            <table class="min-w-full table-auto text-sm border-collapse">
                                <thead class="">
                                    <tr class="bg-neutral-800 text-white">
                                        <th class="py-2 px-4 text-left">Nombre</th>
                                        <th class="py-2 px-4 text-left">Apellido</th>
                                        <th class="py-2 px-4 text-left">Correo</th>
                                        <th class="py-2 px-4 text-left">Teléfono</th>
                                        <th class="py-2 px-4 text-left">Nombre de Usuario</th>
                                        <th class="py-2 px-4 text-left">Estado</th>
                                        <th class="py-2 px-4 text-left">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="border border-gray-300 border-b-2 border-b-gray-400">
                                    <?php foreach ($listaUsuarios as $usuario): ?>
                                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($usuario['nombreUsuario']); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-medium <?php echo intval($usuario['estado']) === 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> rounded-full">
                                                    <?php echo intval($usuario['estado']) === 1 ? 'Activo' : 'Inactivo'; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-2">
                                                <form method="POST" action="getGUP.php">
                                                <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>">
                                                    <button 
                                                    name="btnEditarUsuario" value="btnEditarUsuario"
                                                    class="bg-neutral-800 text-white px-3 py-2 rounded hover:bg-neutral-700">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="getGUP.php">
                                                    <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>">
                                                    <button
                                                    name="btnEliminarUsuario" value="btnEliminarUsuario"
                                                    class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
                                                        <i class="fas fa-trash"></i>
                                                    </button>                                      
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </body>
    <?php
    }
}
?>
