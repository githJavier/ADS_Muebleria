<?php
class mensajeSistema{
    public function mensajeSistemaShow($mensaje, $ruta, $tipo = "", $suceso = false){
        ?>
        <!-- Modal -->
        <div id="myModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg w-1/3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-4 py-2 border-b">
                    <h4 class="text-xl font-bold">
                        <?php echo $suceso ? '¡Éxito!' : '¡Error!'; ?>
                    </h4>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <p class="text-center text-gray-700">
                        <?php echo strtoupper($mensaje); ?>
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-center px-6 py-4 border-t">
                    <?php
                    $buttonClass = $suceso ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600';
                    ?>
                    <button class="px-4 py-2 text-white rounded-md <?php echo $buttonClass; ?>" 
                            onclick="redirigir('<?php echo $ruta; ?>')">
                        OK
                    </button>
                </div>
            </div>
        </div>

        <!-- Script -->
        <script>
            // Mostrar el modal
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('myModal').classList.remove('hidden');
            });

            // Cerrar el modal
            function closeModal() {
                document.getElementById('myModal').classList.add('hidden');
            }

            // Redirigir a otra página
            function redirigir(enlace) {
                <?php if ($tipo === "systemOut"): ?>
                    window.location.href = "<?php echo $ruta; ?>";
                <?php else: ?>
                    closeModal();
                <?php endif; ?>
            }
        </script>
        <?php
    }
}
?>