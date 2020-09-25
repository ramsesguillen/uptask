    <!-- <script src="js/sweetalert2.all.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php 
        $actual = obtenerPaginaActual(); 
        if ( $actual == 'crear-cuenta' || $actual == 'login' ) {?>
            <script src="js/formulario.js"></script>
        <?php } else {
            echo '<script src="js/scripts.js"></script>';
        } ?>
</body>
</html>