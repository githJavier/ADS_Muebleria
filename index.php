<?php
    include ("securityModule/autenticacionUsuario/formAutenticarUsuario.php");
    
    $objetoFormAutenticar = new FormAutenticarUsuario();
    $objetoFormAutenticar -> formAutenticarUsuarioShow();
?>