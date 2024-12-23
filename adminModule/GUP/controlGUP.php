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
        include '../../model/Usuario.php';
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
        include '../../model/rol.php';
        include '../../model/privilegio.php';
        include '../../model/usuariorol.php';
        include '../../model/UsuarioPrivilegio.php';

        $objUsuario = new usuario();
        $objRol = new rol();
        $objPrivilegio = new privilegio();
        $objUsuarioRol = new UsuarioRol();
        $objUsuarioPrivilegio = new UsuarioPrivilegio();

        if ($objUsuario->validarUsuario($nombreUsuario)) {
            $this->mostrarMensaje("El nombre de usuario '$nombreUsuario' ya existe.");
            return;
        }

        // Validar roles existentes
        foreach ($roles as $idRol) {
            if (!$objRol->validarRolExistente($idRol)) {
                $this->mostrarMensaje("El rol seleccionado con ID '$idRol' no existe.");
                return;
            }
        }

        // Validar privilegios existentes
        foreach ($privilegios as $idPrivilegio) {
            if (!$objPrivilegio->validarPrivilegioExistente($idPrivilegio)) {
                $this->mostrarMensaje("El privilegio seleccionado con ID '$idPrivilegio' no existe.");
                return;
            }
        }

        // Agregar el usuario si todo es válido
        $idUsuario = $objUsuario->agregarUsuario($nombre, $apellido, $correo, $telefono, $nombreUsuario, $clave, $estado, $preguntaSeguridad, $respuestaSeguridad);

        if ($idUsuario) {
            // Asignar roles
            foreach ($roles as $idRol) {
                $objUsuarioRol->asignarRol($idUsuario, $idRol);
            }

            // Asignar privilegios
            foreach ($privilegios as $idPrivilegio) {
                $objUsuarioPrivilegio->asignarPrivilegio($idUsuario, $idPrivilegio);
            }

            $this->mensajeExitoso("Usuario agregado exitosamente.");
        } else {
            $this->mostrarMensaje("Error al agregar el usuario.");
        }
    }

    public function mostrarFormularioEditarUsuario($idUsuario) {
        include_once '../../model/Usuario.php';
        include_once '../../model/rol.php';
        include_once '../../model/privilegio.php';
        include_once '../../model/usuariorol.php';
        include_once '../../model/UsuarioPrivilegio.php';
        
        
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
        include_once 'formEditarUsuario.php';
        $formEditarUsuario = new formEditarUsuario();
        $formEditarUsuario->formEditarUsuarioShow($usuario, $roles, $privilegios, $rolesAsignados, $privilegiosAsignados);
    }

    public function actualizarUsuario(
        $idUsuario,
        $nombre,
        $apellido,
        $correo,
        $telefono,
        $nombreUsuario,
        $clave,
        $estado,
        $preguntaSeguridad,
        $respuestaSeguridad,
        $roles,
        $privilegios
    ) {
        include_once '../../model/usuario.php';
        include_once '../../model/usuariorol.php';
        include_once '../../model/UsuarioPrivilegio.php';
    
        $objUsuario = new usuario();
        $objUsuarioRol = new UsuarioRol();
        $objUsuarioPrivilegio = new UsuarioPrivilegio();
    
        try {
            // Validar si el nombre de usuario ya existe para otro usuario
            if ($objUsuario->validarUsuarioExistente($idUsuario, $nombreUsuario)) {
                throw new Exception("El nombre de usuario '$nombreUsuario' ya está en uso por otro usuario.");
            }
    
            // Validar roles
            if (empty($roles) || !validarArrayEnteros($roles)) {
                throw new Exception("Los roles proporcionados no son válidos.");
            }
    
            // Validar privilegios
            if (empty($privilegios) || !validarArrayEnteros($privilegios)) {
                throw new Exception("Los privilegios proporcionados no son válidos.");
            }
    
            // Iniciar transacción para asegurar atomicidad
            $objUsuario->iniciarTransaccion();
    
            // Actualizar información del usuario
            $resultadoUsuario = $objUsuario->actualizarUsuario(
                $idUsuario,
                $nombre,
                $apellido,
                $correo,
                $telefono,
                $nombreUsuario,
                $clave,
                $estado,
                $preguntaSeguridad,
                $respuestaSeguridad
            );
    
            if (!$resultadoUsuario) {
                throw new Exception("Error al actualizar la información del usuario.");
            }
    
            // Eliminar roles existentes y asignar nuevos
            if (!$objUsuarioRol->eliminarRolesPorUsuario($idUsuario)) {
                throw new Exception("Error al eliminar los roles anteriores del usuario.");
            }
    
            foreach ($roles as $idRol) {
                if (!$objUsuarioRol->asignarRol($idUsuario, $idRol)) {
                    throw new Exception("Error al asignar el rol con ID $idRol.");
                }
            }
    
            // Eliminar privilegios existentes y asignar nuevos
            if (!$objUsuarioPrivilegio->eliminarPrivilegiosPorUsuario($idUsuario)) {
                throw new Exception("Error al eliminar los privilegios anteriores del usuario.");
            }
    
            foreach ($privilegios as $idPrivilegio) {
                if (!$objUsuarioPrivilegio->asignarPrivilegio($idUsuario, $idPrivilegio)) {
                    throw new Exception("Error al asignar el privilegio con ID $idPrivilegio.");
                }
            }
    
            // Confirmar transacción si todo es exitoso
            $objUsuario->confirmarTransaccion();
            $this->mensajeExitoso("Usuario actualizado exitosamente.");
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $objUsuario->revertirTransaccion();
            $this->mostrarMensaje($e->getMessage());
        }
    }
    

    public function eliminarUsuario($idUsuario) {
        include_once '../../model/Usuario.php';
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
