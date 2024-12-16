<?php
class MensajeVulnerabilidadSistema
{
    public function mostrarMensaje($titulo, $mensaje)
    {
?>
        <div>
            <div>
                <h1><?php echo $titulo; ?></h1>
                <p><?php echo $mensaje; ?></p>
            </div>
            <div>
                <a href="../../index.php">Volver a la página principal</a>
            </div>
        </div>
<?php
    }
}
