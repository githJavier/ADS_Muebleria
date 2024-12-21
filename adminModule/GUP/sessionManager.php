<?php

// Verifica si el usuario está autenticado
function verificarSesion() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../securityModule/getLogin.php");
        exit();
    }
}

// Retorna el usuario de la sesión
function obtenerUsuarioSesion() {
    return $_SESSION['usuario'] ?? null;
}
// Retorna el usuario de la sesión
function obtenerPrivilegiosSesion() {
    return $_SESSION['listarprivilegios'] ?? null;
}
// Retorna el usuario de la sesión
function obtenerRolSesion() {
    return $_SESSION['rol'] ?? null;
}
