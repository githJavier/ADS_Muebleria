<?php
class ControlGUP {
    private function mostrarMensaje($mensaje) {
        include 'ScreenMensaje.php';
        $objMensaje = new ScreenMensaje();
        $objMensaje->screenMensajeShow($mensaje);
    }

    private function mensajeExitoso($mensaje) {
        include 'ScreenMensaje.php';
        $objMensaje = new ScreenMensaje();
        $objMensaje->screenSuccessful($mensaje);
    }
    
    public function obtenerListaGUP() {
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
        include '../../model/usuario.php';
        $objUsuario = new usuario();

        if ($objUsuario->validarUsuario($nombreUsuario)) {
            $this->mostrarMensaje("El nombre de usuario '$nombreUsuario' ya existe.");
        } else {
            $idUsuario = $objUsuario->agregarUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad);

            if ($idUsuario) {
                if (!empty($roles)) {
                    include '../../model/usuariorol.php';
                    $objUsuarioRol = new UsuarioRol();
                    foreach ($roles as $idRol) {
                        $objUsuarioRol->asignarRol($idUsuario, $idRol);
                    }
                }

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

    public function mostrarFormularioEditarUsuario($idUsuario) {
        include '../../model/usuario.php';
        include '../../model/rol.php';
        include '../../model/privilegio.php';
        include '../../model/usuariorol.php';
        include '../../model/UsuarioPrivilegio.php';

        $objUsuario = new usuario();
        $objRol = new rol();
        $objPrivilegio = new privilegio();
        $objUsuarioRol = new UsuarioRol();
        $objUsuarioPrivilegio = new UsuarioPrivilegio();

        // Obtener información del usuario por ID
        $usuario = $objUsuario->obtenerUsuarioPorId($idUsuario);

        // Listar todos los roles y privilegios
        $roles = $objRol->listarRoles();
        $privilegios = $objPrivilegio->listarPrivilegios();

        // Obtener roles y privilegios asignados al usuario
        $rolesAsignados = $objUsuarioRol->obtenerRolesPorUsuario($idUsuario);
        $privilegiosAsignados = $objUsuarioPrivilegio->obtenerPrivilegiosPorUsuario($idUsuario);

        // Incluir y mostrar el formulario de edición
        include 'formEditarUsuario.php';
        $formEditarUsuario = new formEditarUsuario();
        $formEditarUsuario->formEditarUsuarioShow($usuario, $roles, $privilegios, $rolesAsignados, $privilegiosAsignados);
    }

    public function actualizarUsuario($idUsuario, $nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad, $roles, $privilegios) {
        include '../../model/usuario.php';
        include '../../model/usuariorol.php';
        include '../../model/UsuarioPrivilegio.php';
    
        $objUsuario = new usuario();
        $objUsuarioRol = new UsuarioRol();
        $objUsuarioPrivilegio = new UsuarioPrivilegio();
    
        // Verificar si el nombre de usuario ya existe
        if ($objUsuario->validarUsuarioExistente($idUsuario, $nombreUsuario)) {
            $this->mostrarMensaje("El nombre de usuario '$nombreUsuario' ya existe.");
            return;
        }
    
        // Actualizar el usuario
        $resultado = $objUsuario->actualizarUsuario($idUsuario, $nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad);
    
        if ($resultado) {
            // Eliminar roles anteriores y asignar nuevos roles
            $objUsuarioRol->eliminarRolesPorUsuario($idUsuario);
            foreach ($roles as $idRol) {
                $objUsuarioRol->asignarRol($idUsuario, $idRol);
            }
    
            // Eliminar privilegios anteriores y asignar nuevos privilegios
            $objUsuarioPrivilegio->eliminarPrivilegiosPorUsuario($idUsuario);
            foreach ($privilegios as $idPrivilegio) {
                $objUsuarioPrivilegio->asignarPrivilegio($idUsuario, $idPrivilegio);
            }
    
            $this->mensajeExitoso("Usuario actualizado exitosamente.");
        } else {
            $this->mostrarMensaje("Error al actualizar el usuario.");
        }
    }

    public function eliminarUsuario($idUsuario) {
        include '../../model/usuario.php';
        include '../../model/usuariorol.php';
        include '../../model/UsuarioPrivilegio.php';
    
        $objUsuario = new usuario();
        $objUsuarioRol = new UsuarioRol();
        $objUsuarioPrivilegio = new UsuarioPrivilegio();
    
        // Eliminar roles asociados
        $objUsuarioRol->eliminarRolesPorUsuario($idUsuario);
    
        // Eliminar privilegios asociados
        $objUsuarioPrivilegio->eliminarPrivilegiosPorUsuario($idUsuario);
    
        // Eliminar el usuario
        $resultado = $objUsuario->eliminarUsuarioPorId($idUsuario);
    
        if ($resultado) {
            $this->mensajeExitoso("Usuario eliminado exitosamente.");
        } else {
            $this->mostrarMensaje("Error al eliminar el usuario.");
        }
    }
}
?>
