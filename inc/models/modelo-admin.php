<?php

$accion   = $_POST['accion'];
$password = $_POST['password'];
$usuario   = $_POST['usuario'];


/** 
 * ! Crear los administradores
*/

if ( $accion === 'crear' ) {

    // Hashear password 
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash( $password, PASSWORD_BCRYPT, $opciones );

    // importar la conexion 
    include '../functions/conexion.php';

    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?,?)");
        $stmt->bind_param('ss', $usuario, $hash_password);
        $stmt->execute();

        if ( $stmt->affected_rows > 0 ) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id,
                'tipo' => $accion
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode( $respuesta );
}

/**
 * *LOGUEAR USAURIO
 */

if ( $accion === 'login') {
    // importar la conexion 
    include '../functions/conexion.php';

    try {
        $stmt = $conn->prepare("SELECT usuario, id_user, password FROM usuarios WHERE usuario = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();

        $stmt->bind_result( $nombre_usuario, $id_usuario, $pass_usuario );
        $stmt->fetch();
        if ( $nombre_usuario ) {
            // El usuario existe, verificar el password 
            if ( password_verify( $password, $pass_usuario ) ) {
                // iniciar sesion 
                session_start();
                $_SESSION['nombre'] = $usuario;
                $_SESSION['id'] = $id_usuario;
                $_SESSION['login'] = true;
                
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $nombre_usuario,
                    'id' => $id_usuario,
                    'password' => $pass_usuario,
                    'tipo' => $accion
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'El no existe'
                );
            }
        } else {
            $respuesta = array(
                'error' => 'El usuario no existe'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode( $respuesta );
}
