<?php 
    include_once("../../shared/renderHeader.php");
class PanelPrincipalUsuario {
    public function mostrarPanel() {
        $usuario = $_SESSION['usuario']; // Obtiene el nombre de usuario o identificador
        $listarprivilegios = $_SESSION['listarprivilegios']; // Obtiene el array de privilegios
        $rol = $_SESSION['rol']; // Obtiene el rol del usuario
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Sistema POS - Muebles");
        ?>
        <html>
            <body class="bg-white text-gray-900 flex flex-col min-h-screen">
                <div class="flex flex-1">
                    <!-- Panel lateral fijo -->
                    <div class="w-80 bg-neutral-800 p-6 flex flex-col justify-between shadow-lg fixed h-full">
                        <div>
                            <!-- Perfil Usuario -->
                            <?php $this->perfilUsuario($usuario, $rol, $listarprivilegios); ?>
                        </div>
                        <!-- Cerrar Sesión -->
                        <?php $this->formCerrarSesion("../cerrarSesion.php");?>
                    </div>
                    
                    <!-- Contenido principal con margen izquierdo para el panel fijo -->
                    <div class="flex-1 bg-white flex items-center justify-center p-8 ml-80">
                        <!-- Contenido Principal -->
                    </div>
                </div>
                <!-- Footer -->
                <?php $this->mostrarFooter() ?>
            </body>
        </html>
    <?php
    }

    public function mostrarFooter() {
        ?>
        <footer class="w-full flex flex-row">
            <div class="w-80 bg-neutral-800">
            </div>
            <div class="flex-1 bg-transparent text-neutral-800 text-center py-4">
                <p>&copy; 2024 Sistema POS - Muebles. Todos los derechos reservados.</p>
            </div>
        </footer>
        <?php
    }

    public function formCerrarSesion($rutaCerrar) {
        ?>
        <form action="<?php echo $rutaCerrar ?>">
            <button class="w-full bg-black border-2  hover:bg-red-700 border-transparent hover:border-zinc-100 py-2 rounded-md flex items-center justify-center text-white text-base">
                Cerrar sesión
            </button>
        </form>
        <?php
    }

    public function perfilUsuario($usuario, $rol, $listarprivilegios) {
        ?>
        <!-- Perfil de usuario -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zm0 1.5c-4.128 0-7.5 2.686-7.5 6v1.5h15v-1.5c0-3.314-3.372-6-7.5-6z" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-white">Bienvenido, <?php echo $usuario ?></h2>
            <p class="text-sm text-gray-400">Cargo: <?php echo $rol ?></p>
        </div>
        <!-- Botones de privilegios -->
        <?php 
        foreach ($listarprivilegios as $privilegio) { ?>
            <form method="post" action="<?php echo $privilegio['pathPrivilegio'] ?>">
                <button class="w-full bg-white hover:bg-black border-2 border-transparent hover:border-zinc-100 hover:text-white py-2 rounded-md flex items-center justify-center mb-4 text-gray-700 text-base" name="<?php echo $privilegio['name'] ?>" value="<?php echo $privilegio['name'] ?>">
                    <i class="fas fa-<?php echo $privilegio['iconPrivilegio'] ?> w-5"></i>
                    <span class="mx-4"><?php echo $privilegio['labelPrivilegio'] ?></span>
                </button>
            </form>
        <?php } ?>
        <?php
    }
}
?>
