<?php 
/**
 * Obtiene la pagina actual
 *
 * @return void
 */
function obtenerPaginaActual()
{
    $archivo = basename( $_SERVER['PHP_SELF'] );
    $pagina = str_replace('.php', '', $archivo);
    return $pagina;
}

/**
 * * CONSULTAS
 * 
 */

 /**
  * Undocumented function
  *
  * @return void
  */
 function obtenerProyecto()
 {
    include 'conexion.php';
    try {
        return $conn->query('SELECT id_proyecto, nombre_proyecto FROM proyectos');
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage();
        return false;
    }
 }

 /**
  * * Obtejer Nombre del Proyecto
  */

function obtenerNompreProyecto( $id = null )
{
    include 'conexion.php';
    try {
        return $conn->query("SELECT nombre_proyecto FROM proyectos WHERE id_proyecto = $id");
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage();
        return false;
    }
}

/**
 *  * Obtener las tareas del proyecto
 * 
 */

function obtenerTareasProyecto( $id = null )
{
    include 'conexion.php';
    try {
        return $conn->query("SELECT id_tarea, nombre_tarea, estado FROM tareas WHERE id_proyecto = $id");
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage();
        return false;
    }
}


