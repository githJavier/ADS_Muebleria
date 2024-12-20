<?php
include '../../shared/renderHeader.php';
include '../../securityModule/panelPrincipalUsuario.php';

class formGUP {
    public function formGUPShow($listaUsuarios) {

        include 'sessionManager.php';
        verificarSesion(); // Verifica si la sesión está activa
        // $usuario = obtenerUsuarioSesion();
        // $listarprivilegios = obtenerPrivilegiosSesion();
        // $rol = obtenerRolSesion();


        $objCabecera = new renderHeader();
        $objCabecera->cabeceraShow("Gestión de Usuarios y Privilegios");
        // $panelPrincipal = new PanelPrincipalUsuario;


        
// $f = new usuario();
// $f ->listarUsuariosParaGestion();

// echo("<pre>");
// var_dump($listaUsuarios);
// echo("</pre>");
// exit;
        
        ?>
    <body class="bg-white text-gray-900 flex flex-col min-h-screen">
        

        <div class="p-6 bg-gray-50 min-h-screen">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-gray-700">Gestión de Usuarios</h1>
                <form method="POST" action="getGUP.php">
                    <button 
                    name="btnAgregarUsuario" value="btnAgregarUsuario"
                    class="bg-custom text-white px-4 py-2 rounded hover:bg-red-600">
                        <i class="fas fa-user-plus mr-2"></i> Agregar Usuario
                    </button>
                </form>
            </div>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full border-collapse divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($listaUsuarios as $usuario): ?>
                            
                            <tr>
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
                                        <button 
                                        name="btnEditarUsuario" value="btnEditarUsuario"
                                        class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="getGUP.php">
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
    </body>
        <?php
    }
}
?>
