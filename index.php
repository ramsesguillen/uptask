<?php  include 'inc/functions/sesiones.php' ?>
<?php  include 'inc/functions/funciones.php' ?>
<?php  include 'inc/templates/header.php' ?>
<?php  include 'inc/templates/barra.php' ?>

<?php 
    // obtener el id 
    if ( isset( $_GET['id_proyecto'] ) ) {
        $id_proyecto = $_GET['id_proyecto'];
    } else {
        $id_proyecto = '';
    }

?>



 
<div class="contenedor">
    
    
<?php  include 'inc/templates/sidebar.php' ?>

    <main class="contenido-principal">
        <?php $proyecto = obtenerNompreProyecto( $id_proyecto ); ?>

        <?php if ( $proyecto ): ?>
        <h1>Proyecto actual: 
            <?php foreach ($proyecto as $p):?>
                    <span><?= $p['nombre_proyecto'] ?></span> 
            <?php endforeach; ?>
        </h1>

        <form action="#" class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Tarea:</label>
                <input type="text" placeholder="Nombre Tarea" class="nombre-tarea"> 
            </div>
            <div class="campo enviar">
                <input type="hidden" id="id-proyecto" value="<?= $id_proyecto ?>">
                <input type="submit" class="boton nueva-tarea" value="Agregar">
            </div>
        </form>
        
        <?php else: echo "<p>Selcciona un Proyecto a la izquierda</p>"; endif; ?>
 

        <h2>Listado de tareas:</h2>

        <div class="listado-pendientes">
            <ul>
                <?php 
                    $tareas = obtenerTareasProyecto( $id_proyecto );
                    if ( $tareas->num_rows > 0 ):?>
                        <?php foreach( $tareas as $tarea): ?>
                            <li id="tarea:<?= $tarea['id_tarea'] ?>" class="tarea">
                            <p><?= $tarea['nombre_tarea'] ?></p>
                                <div class="acciones">
                                    <i class="far fa-check-circle  <?= ($tarea['estado'] == 1 ) ? 'completo' : ''?>"></i>
                                    <i class="fas fa-trash"></i>
                                </div>
                            </li>  
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="lista-vacia">No hay tareas</p>
                    <?php endif; ?>     
            </ul>
        </div>

        <div class="avance">
            <h2>Avance del Proyecto:</h2>
            <div id="barra-avance" class="barra-avance">
                <div class="porcentaje" id="porcentaje"></div>
            </div>
        </div>
    </main>
</div><!--.contenedor-->


<?php  include 'inc/templates/footer.php' ?>