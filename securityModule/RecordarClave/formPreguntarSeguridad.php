<?php
include_once("shared/renderHeader.php");

class FormPreguntarSeguridad {
    public function formPreguntarSeguridadShow($usuario, $pregunta) {
        $objCabecera = new renderHeader;
        $objCabecera->cabeceraShow("Recuperar Contraseña - Sistema POS");

        ?>
        <body>
            <main class="flex h-screen">
                <!-- Sección Izquierda (Imagen y Contenido) -->
                <div class="hidden lg:block w-1/2 bg-black relative">
                    <div class="absolute inset-0 flex flex-col justify-between p-12">
                        <div>
                            <img src="./img/licla.png" alt="Logo Muebles Licla" class="h-12 w-auto">
                        </div>
                        <div class="text-white space-y-6 z-10">
                            <h1 class="text-4xl font-bold">Recuperar tu contraseña</h1>
                            <p class="text-lg text-gray-300">Responde la pregunta de seguridad para continuar</p>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 h-2/3 z-0">
                            <img src="./img/cama.avif" alt="Decorative Pattern" class="h-full w-full object-cover opacity-50">
                            <div class="absolute inset-0 bg-gradient-to-b from-black via-black/50 to-transparent"></div>
                        </div>
                    </div>
                </div>

                <!-- Sección Derecha (Formulario) -->
                <div class="w-full lg:w-1/2 flex items-center justify-center bg-white px-8">
                    <form class="space-y-6 w-full max-w-md" method="POST" action="getRecordarClave.php">
                        <h2 class="text-2xl font-bold text-center">Pregunta de Seguridad</h2>

                        <p class="text-gray-700"><?php echo htmlspecialchars($pregunta); ?></p>

                        <!-- Respuesta de Seguridad -->
                        <div>
                            <label for="txtRespuesta" class="block text-sm font-medium text-gray-700">Respuesta</label>
                            <div class="relative mt-1">
                                <input 
                                    id="txtRespuesta" 
                                    name="txtRespuesta" 
                                    type="text" 
                                    placeholder="Ingresa tu respuesta" 
                                    required
                                    class="block w-full py-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom focus:border-custom sm:text-sm">
                            </div>
                        </div>

                        <input type="hidden" name="txtUsuario" value="<?php echo htmlspecialchars($usuario); ?>">

                        <button type="submit" name="btnVerificarRespuesta" class="w-full bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                            Continuar
                        </button>
                    </form>
                </div>
            </main>
        </body>
        </html>
        <?php
    }
}
?>
