<?php
session_start();
function validaBoton($boton) {
    return isset($boton);
}
function verificarSesionIniciada() {
    return isset($_SESSION['usuario']);
}


function mostrarMensaje($mensaje) {
    include 'ScreenMensaje.php';
    $objMensaje = new ScreenMensaje();
    $objMensaje->screenMensajeShow($mensaje, "getGUP.php");
}

// Funciones de validación para cada campo
function validarNombre($nombre) {
    return !empty($nombre) && preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/", $nombre);
}

function validarCorreo($correo) {
    return filter_var($correo, FILTER_VALIDATE_EMAIL);
}

function validarTelefono($telefono) {
    return preg_match("/^\d{9}$/", $telefono);
}

function validarClave($clave) {
    return strlen($clave) >= 3;
}

function validarTextoConLongitud($texto, $longitudMinima = 3, $longitudMaxima = 100) {
    $longitud = strlen(trim($texto));
    return $longitud >= $longitudMinima && $longitud <= $longitudMaxima;
}

function validarRol($roles) {
    // Verifica que se haya enviado un único rol
    return count($roles) === 1;
}

// Función para validar un array de enteros (roles, privilegios)
function validarArrayEnteros($array) {
    foreach ($array as $valor) {
        if (!ctype_digit($valor)) {
            return false;
        }
    }
    return true;
}

function validarTextoLetrasEspacios($texto) {
    return !empty($texto) && preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $texto);
}



function validarIdUsuario($id) {
    // Verifica que esté definido y sea un número entero
    if (isset($id) && ctype_digit($id) && (int)$id > 0) {
        return true;
    }
    return false;
}


// Capturar botones
$btnGUP = $_POST['btnGUP'] ?? null;
$btnAgregarUsuario = $_POST['btnAgregarUsuario'] ?? null;
$btnCrearUsuario = $_POST['btnCrearUsuario'] ?? null;
$btnEditarUsuario = $_POST['btnEditarUsuario'] ?? null;
$btnActualizarUsuario = $_POST['btnActualizarUsuario'] ?? null;
$btnEliminarUsuario = $_POST['btnEliminarUsuario'] ?? null;

if (validaBoton($btnGUP)) {
    if(verificarSesionIniciada()){
        include 'controlGUP.php';
        $objControlGUP = new ControlGUP();
        $objControlGUP->obtenerListaGUP();
    }
} else if (validaBoton($btnAgregarUsuario)) {
    include 'controlGUP.php';
    $objControlGUP = new ControlGUP();
    $objControlGUP->mostrarFormularioAgregarUsuario();
} else if (validaBoton($btnCrearUsuario)) {
    // Validar los datos del formulario
    $nombre = $_POST['txtNombre'];
    $apellido = $_POST['txtApellido'];
    $correo = $_POST['txtCorreo'];
    $telefono = $_POST['txtTelefono'];
    $nombreUsuario = $_POST['txtUsuario'];
    $clave = $_POST['txtClave'];
    $estado = $_POST['checkEstado'] ?? null;
    $preguntaSeguridad = $_POST['textPregunta'];
    $respuestaSeguridad = $_POST['textRespuesta'];
    $roles = $_POST['roles'] ?? [];
    $privilegios = $_POST['privilegios'] ?? [];

    if (validarNombre($nombre)) {
        if (validarNombre($apellido)) {
            if (validarCorreo($correo)) {
                if (validarTelefono($telefono)) {
                    if (validarNombre($nombreUsuario)) {
                        if (validarClave($clave)) {
                            if (validarTextoLetrasEspacios($preguntaSeguridad)) {
                                if (validarTextoConLongitud($preguntaSeguridad, 3, 100)) {
                                    if (validarTextoLetrasEspacios($respuestaSeguridad)) {
                                        if (validarTextoConLongitud($respuestaSeguridad, 3, 100)) {
                                            if (validarArrayEnteros($roles)) {
                                                if (validarRol($roles)) {
                                                    if (validarArrayEnteros($privilegios)) {
                                                        include 'controlGUP.php';
                                                        
                                                        $objControlGUP = new ControlGUP();
                                                        $objControlGUP->crearUsuario(
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
                                                        );
                                                    } else {
                                                        mostrarMensaje("Los privilegios seleccionados no son válidos.");
                                                    }
                                                } else {
                                                    mostrarMensaje("Accion de rol no permitida");
                                                }
                                            } else {
                                                mostrarMensaje("Los roles seleccionados no son válidos.");
                                            }
                                        } else {
                                            mostrarMensaje("La respuesta de seguridad debe tener entre 10 y 100 caracteres.");
                                        }
                                    } else {
                                        mostrarMensaje("La respuesta de seguridad solo puede contener letras y espacios.");
                                    }
                                } else {
                                    mostrarMensaje("La pregunta de seguridad debe tener entre 10 y 100 caracteres.");
                                }
                            } else {
                                mostrarMensaje("La pregunta de seguridad solo puede contener letras y espacios.");
                            }
                        } else {
                            mostrarMensaje("La contraseña debe tener al menos 5 caracteres.");
                        }
                    } else {
                        mostrarMensaje("El nombre de usuario no es válido.");
                    }
                } else {
                    mostrarMensaje("El teléfono debe tener 9 dígitos.");
                }
            } else {
                mostrarMensaje("El correo electrónico no es válido.");
            }
        } else {
            mostrarMensaje("El apellido no es válido.");
        }
    } else {
        mostrarMensaje("El nombre no es válido.");
    }
} else if (validaBoton($btnEditarUsuario)) {
    $idUsuario = $_POST['idUsuario'] ?? null;

    if (validarIdUsuario($idUsuario)) {
        include_once '../../model/Usuario.php';
        $objUsuario = new usuario();
        $idUsuarioSesion = $objUsuario->obtenerIdUsuarioPorNombre($_SESSION['usuario']);

        if ($idUsuarioSesion == $idUsuario) {
            mostrarMensaje("No puedes editar tu propia cuenta desde el menú de gestión.");
        } else {
            include 'controlGUP.php';
            $objControlGUP = new controlGUP();
            $objControlGUP->mostrarFormularioEditarUsuario($idUsuario);
        }
    } else {
        mostrarMensaje("Error: No se proporcionó un ID de usuario válido.");
    }
} else if (validaBoton($btnActualizarUsuario)) {
    // Capturar los datos del formulario
    $idUsuario = $_POST['idUsuario'];
    $nombre = $_POST['txtNombre'];
    $apellido = $_POST['txtApellido'];
    $correo = $_POST['txtCorreo'];
    $telefono = $_POST['txtTelefono'];
    $nombreUsuario = $_POST['txtUsuario'];
    $clave = $_POST['txtClave'];
    $estado = $_POST['checkEstado'] ?? null;
    $preguntaSeguridad = $_POST['textPregunta'];
    $respuestaSeguridad = $_POST['textRespuesta'];
    $roles = $_POST['roles'] ?? [];
    $privilegios = $_POST['privilegios'] ?? [];

    // Validar los datos
    if (validarIdUsuario($idUsuario)) {
        if (validarNombre($nombre)) {
            if (validarNombre($apellido)) {
                if (validarCorreo($correo)) {
                    if (validarTelefono($telefono)) {
                        if (empty($clave) || validarClave($clave)) {
                            if (validarTextoLetrasEspacios($preguntaSeguridad)) {
                                if (validarTextoConLongitud($preguntaSeguridad, 3, 100)) {
                                    if (validarTextoLetrasEspacios($respuestaSeguridad)) {
                                        if (validarTextoConLongitud($respuestaSeguridad, 3, 100)) {
                                            if (validarArrayEnteros($roles)) {
                                                if (validarRol($roles)) {
                                                    if (validarArrayEnteros($privilegios)) {
                                                        // Todo es válido, proceder con la actualización
                                                        include 'controlGUP.php';
                                                        $objControlGUP = new ControlGUP();
                                                        $objControlGUP->actualizarUsuario(
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
                                                        );
                                                    } else {
                                                        mostrarMensaje("Los privilegios seleccionados no son válidos.");
                                                    }
                                                } else {
                                                    mostrarMensaje("Debe seleccionar un único rol válido.");
                                                }
                                            } else {
                                                mostrarMensaje("Los roles seleccionados no son válidos.");
                                            }
                                        } else {
                                            mostrarMensaje("La respuesta de seguridad debe tener entre 3 y 100 caracteres.");
                                        }
                                    } else {
                                        mostrarMensaje("La respuesta de seguridad solo puede contener letras y espacios.");
                                    }
                                } else {
                                    mostrarMensaje("La pregunta de seguridad debe tener entre 3 y 100 caracteres.");
                                }
                            } else {
                                mostrarMensaje("La pregunta de seguridad solo puede contener letras y espacios.");
                            }
                        } else {
                            mostrarMensaje("La contraseña debe tener al menos 3 caracteres.");
                        }
                    } else {
                        mostrarMensaje("El teléfono debe tener 9 dígitos.");
                    }
                } else {
                    mostrarMensaje("El correo electrónico no es válido.");
                }
            } else {
                mostrarMensaje("El apellido no es válido.");
            }
        } else {
            mostrarMensaje("El nombre no es válido.");
        }
    } else {
        mostrarMensaje("Error: ID de usuario no válido.");
    }
} else if (validaBoton($btnEliminarUsuario)) {
    $idUsuario = $_POST['idUsuario'] ?? null;

    if (validarIdUsuario($idUsuario)) {
        include_once '../../model/Usuario.php';
        $objUsuario = new usuario();
        $idUsuarioSesion = $objUsuario->obtenerIdUsuarioPorNombre($_SESSION['usuario']);

        if ($idUsuarioSesion == $idUsuario) {
            mostrarMensaje("No puedes eliminar tu propia cuenta.");
        } else {
            include 'controlGUP.php';
            $objControlGUP = new ControlGUP();
            $objControlGUP->eliminarUsuario($idUsuario);
        }
    } else {
        mostrarMensaje("Error: No se proporcionó un ID de usuario válido para eliminar.");
    }
} else {
    mostrarMensaje("Acceso denegado. No se detectó un intento válido.");
}
