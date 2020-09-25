<?php 

$accion = $_POST['accion'];
$proyecto = $_POST['proyecto'];


/** 
 * ! Insetar Tarea a la BD
*/

if ( $accion === 'crear' ) {


    // importar la conexion 
    include '../functions/conexion.php';

    try {
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre_proyecto) VALUES (?)");
        $stmt->bind_param('s', $proyecto);
        $stmt->execute();

        if ( $stmt->affected_rows > 0 ) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id,
                'tipo' => $accion,
                'nombre_proyecto' => $proyecto
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