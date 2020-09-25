<?php session_start() ?>

<?php  include 'inc/functions/funciones.php' ?>
<?php  include 'inc/functions/conexion.php' ?>
<?php  include 'inc/templates/header.php' ?>

<?php 
    if ( isset( $_GET['cerrar_sesion'] ) ) {
        $_SESSION = array();
        session_destroy();
    }

    if ( isset( $_SESSION['nombre'] )) {
        header('Location: index.php');
    }

?>

    <div class="contenedor-formulario">
        <h1>UpTask</h1>
        <form id="formulario" class="caja-login" method="post">
            <div class="campo">
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            </div>
            <div class="campo">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="login">
                <input type="submit" class="boton" value="Iniciar Sesión">
            </div>

            <div class="campo">
                <a href="crear-cuenta.php">Crea una cuenta nueva</a>
            </div>
        </form>
    </div>


<?php  include 'inc/templates/footer.php' ?>