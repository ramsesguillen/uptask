<?php 

$accion = $_POST['accion'];


/** 
 * ! Insetar proyecto a la BD
 */

if ( $accion === 'crear' ) {
    $tarea = $_POST['tarea'];
    $id_proyecto = (int) $_POST['id_proyecto'];

    // importar la conexion 
    include '../functions/conexion.php';

    try {
        $stmt = $conn->prepare("INSERT INTO tareas (nombre_tarea, id_proyecto) VALUES (?,?)");
        $stmt->bind_param('si', $tarea, $id_proyecto);
        $stmt->execute();

        if ( $stmt->affected_rows > 0 ) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id,
                'tipo' => $accion,
                'tarea' => $tarea
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
 * * Actualizar estado
 * 
*/

if ( $accion === 'actualizar' ) {
    $estado = (int) $_POST['estado'];
    $id_tarea = (int) $_POST['id'];
    // importar la conexion 
    include '../functions/conexion.php';

    try {
        $stmt = $conn->prepare("UPDATE tareas SET estado = ? WHERE id_tarea = ?");
        $stmt->bind_param('ii', $estado, $id_tarea);
        $stmt->execute();

        if ( $stmt->affected_rows > 0 ) {
            $respuesta = array(
                'respuesta' => 'correcto',
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
 * * Eliminar la tarea de la BD
 * 
*/

if ( $accion === 'eliminar' ) {
    $estado = (int) $_POST['estado'];
    $id_tarea = (int) $_POST['id'];
    // importar la conexion 
    include '../functions/conexion.php';

    try {
        $stmt = $conn->prepare("DELETE FROM tareas WHERE id_tarea = ?");
        $stmt->bind_param('i', $id_tarea);
        $stmt->execute();

        if ( $stmt->affected_rows > 0 ) {
            $respuesta = array(
                'respuesta' => 'correcto',
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

