<?php
class ControlGUP {
    function mostrarMensaje($mensaje) {
        include 'ScreenMensaje.php';
        $objMensaje = new ScreenMensaje();
        $objMensaje->screenMensajeShow($mensaje);
    }
    function mensajeExitoso($mensaje) {
        include 'ScreenMensaje.php';
        $objMensaje = new ScreenMensaje();
        $objMensaje->screenSuccessful($mensaje);
    }
    
    public function obtenerListaGUP() {
        // Llamar al modelo para obtener la lista de usuarios
        include '../../model/usuario.php';
        $objUsuario = new usuario();
        $listaUsuarios = $objUsuario->listarUsuariosParaGestion();

        include 'formGUP.php';
        $formGUP = new formGUP();
        $formGUP->formGUPShow($listaUsuarios);
    }

    public function mostrarFormularioAgregarUsuario() {
        include '../../model/rol.php';
        include '../../model/privilegio.php';

        $objRol = new rol();
        $objPrivilegio = new privilegio();

        $roles = $objRol->listarRoles();
        $privilegios = $objPrivilegio->listarPrivilegios();

        include 'formAgregarUsuario.php';
        $formAgregarUsuario = new formAgregarUsuario();
        $formAgregarUsuario->formAgregarUsuarioShow($roles, $privilegios);
    }

    public function crearUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad, $roles, $privilegios) {
        // ✅
        
        include '../../model/usuario.php';
        $objUsuario = new usuario();
        // Verificar si el usuario ya existe
        if ($objUsuario->validarUsuario($nombreUsuario)) {
            $this->mostrarMensaje("El nombre de usuario '$nombreUsuario' ya existe.");
            return;
        }
        // echo "<pre>";
        // var_dump($_POST);
        // var_dump('p1');
        // echo "</pre>";
        // exit;
        
        // Agregar el usuario
        $idUsuario = $objUsuario->agregarUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad);

        if ($idUsuario) {
            // Asociar roles al usuario
            if (!empty($roles)) {
                include '../../model/usuariorol.php';
                $objUsuarioRol = new UsuarioRol();
                foreach ($roles as $idRol) {
                    $objUsuarioRol->asignarRol($idUsuario, $idRol);
                }
            }

            // Asociar privilegios al usuario
            if (!empty($privilegios)) {
                include '../../model/UsuarioPrivilegio.php';
                $objUsuarioPrivilegio = new UsuarioPrivilegio();
                foreach ($privilegios as $idPrivilegio) {
                    $objUsuarioPrivilegio->asignarPrivilegio($idUsuario, $idPrivilegio);
                }
            }

            $this->mensajeExitoso("Usuario agregado exitosamente.");
        } else {
            $this->mostrarMensaje("Error al agregar el usuario.");
        }
    }
}
?>
