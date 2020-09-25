/** 
 * * Crear Cuenta
 * * Login
*/

//* REFERENCIAS DEL HTML





//* FUNCIONES 
const validarRegistro = ( e ) => {
    e.preventDefault();

    const usuario  = document.querySelector('#usuario').value,
          password = document.querySelector('#password').value,
          tipo     = document.querySelector('#tipo').value;

    if ( usuario === '' || password === '' ) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ambos campos son obligatorios!',
        });
    } else {
        // Mandar ejecutar ajax 
        const datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('accion', tipo);

        // crear obj ajax 
        const xhr = new XMLHttpRequest();

        xhr.open('POST', 'inc/models/modelo-admin.php', true);

        xhr.onload = function() {
            if ( this.status == 200 ) {
                const {respuesta, tipo, id_insertado} = JSON.parse( xhr.responseText );
                console.log( JSON.parse( xhr.responseText ) );
                if ( respuesta === 'correcto' ) {
                    if ( tipo === 'crear' ) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario Creado',
                            text: 'El usuario se creo correctamente!',
                        });
                    } else if ( tipo === 'login'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Correcto',
                            text: 'Presiona OK para abrir el dashboard!',
                        }).then( result => {
                            if ( result.value) window.location.href = 'index.php';
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error!',
                    });
                }
            }
        }


        xhr.send( datos );
    }
}




//* CARGAR EVENTOS 
const eventListener = () => {
    document.querySelector('#formulario').addEventListener('submit', validarRegistro );
}

eventListener();