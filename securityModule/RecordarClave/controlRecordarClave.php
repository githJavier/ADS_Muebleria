<?php
include_once("../../model/Usuario.php");
include_once("../../shared/ScreenMensaje.php");

class ControlRecordarClave {
    public function mostrarMensaje($mensaje) {
        $objMensaje = new ScreenMensaje();
        $objMensaje->screenMensajeShow($mensaje, "../../viewRecordarClave.php");
    }

    public function verificarUsuarioExistente($usuario) {
        $objUsuario = new Usuario();
        $preguntaSeguridad = $objUsuario->obtenerPreguntaSeguridad($usuario);

        if ($preguntaSeguridad) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['preguntaSeguridad'] = $preguntaSeguridad;
            header("Location: ../../viewPreguntarSeguridad.php");
            exit();
        } else {
            $this->mostrarMensaje("El usuario '$usuario' no está registrado.");
        }
    }

    // Mostrar el formulario de pregunta de seguridad
    public function mostrarFormPregunta($usuario) {
        $objUsuario = new Usuario();

        if ($objUsuario->existeUsuario($usuario)) {
            // Obtener la pregunta de seguridad
            $pregunta = $objUsuario->obtenerPreguntaSeguridad($usuario);

            if ($pregunta) {
                // Mostrar el formulario de pregunta de seguridad
                $objFormPreguntarSeguridad = new FormPreguntarSeguridad();
                $objFormPreguntarSeguridad->formPreguntarSeguridadShow($usuario, $pregunta);
            } else {
                $this->mostrarMensaje("No se encontró una pregunta de seguridad para el usuario.");
            }
        } else {
            $this->mostrarMensaje("El usuario '$usuario' no está registrado en el sistema.");
        }
    }
}
?>
