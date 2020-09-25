<aside class="contenedor-proyectos">
    <div class="panel crear-proyecto">
        <a href="#" class="boton">Nuevo Proyecto <i class="fas fa-plus"></i> </a>
    </div>

    <div class="panel lista-proyectos">
        <h2>Proyectos</h2>
        <ul id="proyectos">
            <?php 
                $proyectos = obtenerProyecto();
                foreach ($proyectos as $proyecto) : ?>
                    <li>
                        <a href="index.php?id_proyecto=<?= $proyecto['id_proyecto'] ?>" id="proyecto:<?= $proyecto['id_proyecto'] ?>">
                                <?= $proyecto['nombre_proyecto'] ?>
                        </a>
                    </li>
                    
            <?php endforeach; ?>
        </ul>
    </div>
</aside>