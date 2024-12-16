<?php 
include_once("../../model/Usuario.php");
include_once("../../shared/mensajeVulnerabilidadSistema.php");
class controlAutenticarUsuario{
    public function mostrarMensaje($mensaje){
        $objMensaje = new MensajeVulnerabilidadSistema();
        $objMensaje->mostrarMensaje("Mensaje del Sistema",$mensaje);
    }
    public function verificarUsuario($usuario, $clave) {
        session_start();
        $objUsuario = new Usuario();
        $resultado = $objUsuario->validarUsuario($usuario);
        
        if($resultado){
            $resultado = $objUsuario->verificaPassword($usuario, $clave);
            if($resultado){
                $resultado = $objUsuario->verificaEstado($usuario);
                if($resultado){
                    include_once("../../model/UsuarioPrivilegio.php");
                    include_once("../../model/rol.php");
                    include_once("../panelPrincipalUsuario.php");
                    $objPP = new PanelPrincipalUsuario();
                    $objUP = new UsuarioPrivilegio();
                    $objUR = new rol();
                    $listaPrivilegios = $objUP->obtenerPrivilegios($usuario);
                    $rolUsuario = $objUR->obtenerRol($usuario);
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['listarprivilegios'] = $listaPrivilegios;
                    $_SESSION['rol'] = $rolUsuario;
                    $_SESSION['login'] = true;
                    $objPP->mostrarPanel();
                }else{
                    $this->mostrarMensaje("El usuario '$usuario' está inhabilitado en el sistema");
                }
            }else{
                $this->mostrarMensaje("El password del usuario '$usuario' es incorrecto");
            }
        }else{
            $this->mostrarMensaje("El usuario: '$usuario' no está registrado");
        }

    }
}


?>