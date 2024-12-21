<?php 
 include_once("shared/renderHeader.php");
class FormAutenticarUsuario{
    public function formAutenticarUsuarioShow(){
    $objCabecera = new renderHeader;
    $objCabecera->cabeceraShow("Sistema POS - Muebles");
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
                                <h1 class="text-4xl font-bold">Bienvenido a Licla</h1>
                                <p class="text-lg text-gray-300">Sistema POS</p>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-2/3 z-0">
                                <img src="./img/cama.avif" alt="Decorative Pattern"
                                    class="h-full w-full object-cover opacity-50">
                                <div class="absolute inset-0 bg-gradient-to-b from-black via-black/50 to-transparent"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección Derecha (Formulario) -->
                    <div class="w-full lg:w-1/2 flex items-center justify-center bg-white px-8">
                        <form class="space-y-6 w-full max-w-md" id="form-login" method="POST" action="./securityModule/autenticacionUsuario/getLogin.php">
                            <h2 class="text-2xl font-bold text-center">Iniciar Sesión</h2>
                            <div class="space-y-4">
                                <!-- Usuario -->
                                <div>
                                    <label for="txtUsuario" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </span>
                                        <input 
                                            id="txtUsuario" 
                                            name="txtUsuario" 
                                            type="text" 
                                            placeholder="mueble777"
                                            required
                                            class="block w-full pl-10 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom focus:border-custom sm:text-sm">
                                    </div>
                                </div>
                                <!-- Contraseña -->
                                <div>
                                    <label for="txtClave" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </span>
                                        <input 
                                            id="txtClave" 
                                            name="txtClave" 
                                            type="password"
                                            placeholder="••••••••"
                                            required
                                            class="block w-full pl-10 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom focus:border-custom sm:text-sm">
                                    </div>
                                </div>
                            </div>
                            <!-- Acciones -->
                            <div class="flex items-center justify-between">
                                <a href="viewRecordarClave.php" class="text-sm font-medium text-custom hover:text-custom">¿Olvidaste tu contraseña?</a>
                            </div>
                            <button type="submit" name="btnIngresar" class="w-full bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                                Iniciar Sesión
                            </button>
                            <p class="text-center text-sm text-gray-500">
                                ¿No tienes una cuenta? <a href="#" class="text-custom font-medium hover:underline">Sal de la Pagina</a>
                            </p>
                            <div class="text-center text-xs text-gray-500 space-x-4">
                                <a href="#" class="hover:text-gray-700">Muebles Licla</a>
                                <span>•</span>
                                <a href="#" class="hover:text-gray-700">Villa el Salvador</a>
                            </div>
                        </form>
                    </div>
                </main>
            </body>
        </html>
    <?php 
    }
}
?>