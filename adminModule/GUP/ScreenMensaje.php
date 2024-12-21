<?php
class ScreenMensaje {
    /**
     * Muestra un mensaje de sistema dentro de la estructura del sistema.
     * 
     * @param string $mensaje El mensaje a mostrar
     * @param string $rutaRedireccion (Opcional) Ruta para el botón de acción.
     */
    public function screenMensajeShow($mensaje, $ruta = "getGUP.php") {

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">    
            <title>Error Modal</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">    
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
            <link href="https://ai-public.creatie.ai/gen_page/tailwind-custom.css" rel="stylesheet">    
            <script src="https://cdn.tailwindcss.com/3.4.5?plugins=forms@0.5.7,typography@0.5.13,aspect-ratio@0.4.2,container-queries@0.1.1"></script>
            <script src="https://ai-public.creatie.ai/gen_page/tailwind-config.min.js" data-color="#000000" data-border-radius="medium"></script>
        </head>
        <body class="bg-gray-100 min-h-screen flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">        
                <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full mx-4 relative">
                    <div class="flex flex-col items-center text-center">                
                        <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mb-6">
                            <i class="fas fa-exclamation-triangle text-4xl text-custom"></i>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Mensaje del Sistema</h2>                
                        <p class="text-gray-600 mb-8"><?php echo $mensaje ?></p>                
                        <form method="POST" action="<?php echo $ruta ?>">                            
                            <button 
                            name="btnGUP"
                            class="bg-custom hover:bg-red-700 text-white font-semibold py-3 px-6 !rounded-button transition duration-200 ease-in-out w-full mb-4">                    
                                Aceptar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    public function screenSuccessful($mensaje, $ruta = "getGUP.php") {
    
        ?>
        <!DOCTYPE html><html lang="es"><head>
            <meta charset="UTF-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title>Error Modal</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
            <link href="https://ai-public.creatie.ai/gen_page/tailwind-custom.css" rel="stylesheet"/>
            <script src="https://cdn.tailwindcss.com/3.4.5?plugins=forms@0.5.7,typography@0.5.13,aspect-ratio@0.4.2,container-queries@0.1.1"></script>
            <script src="https://ai-public.creatie.ai/gen_page/tailwind-config.min.js" data-color="#000000" data-border-radius="medium"></script>
        </head>
        <body class="bg-gray-100 min-h-screen flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full mx-4 relative">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mb-6">
                            <i class="fas fa-check-circle text-4xl text-green-500"></i>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">¡Operación Exitosa!</h2>
                        
                        <p class="text-gray-600 mb-8"><?php echo $mensaje ?></p>
                        <form method="POST" action="<?php echo $ruta ?>">
                            <button 
                            name="btnGUP"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 !rounded-button transition duration-200 ease-in-out w-full mb-4">
                                Aceptar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        <?php
    }
}
?>
