/** 
 * 
 * 
*/

// * REFERENCIAS DEL HTML
const listaProyectos = document.querySelector('ul#proyectos');




// * FUNCIONES
const nuevoPoryecto = ( e ) => {
    e.preventDefault();

    //crea un input para el nuevo proyecto 
    const nuevoPoryecto = document.createElement('li');
    nuevoPoryecto.innerHTML = '<input type="text" id="nuevo-proyecto">'
    listaProyectos.appendChild( nuevoPoryecto );

    // seleccionar el ID con el nuevoProyecto 
    const inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    inputNuevoProyecto.addEventListener('keypress', function ( e ) {
        const tecla = e.which || e.keyCode;
        
        if ( tecla === 13 ) {
            guardarProyectoBD( inputNuevoProyecto.value );
            listaProyectos.removeChild( nuevoPoryecto );
        }
    });   
}

/** 
 * * Guaradar el proyecto en la BD
 * * Crear el nuevo proyecto en html del sidebar
*/
const guardarProyectoBD = ( nombreProyecto ) => {

    // crear mmado a ajax 
    const xhr = new XMLHttpRequest();

    // enviar datos por formdata 
    const datos = new FormData();
    datos.append('proyecto', nombreProyecto );
    datos.append('accion', 'crear');

    xhr.open('POST', 'inc/models/modelo-proyecto.php', true);

    xhr.onload = function() {
        if ( this.status === 200 ) {
            const {respuesta: resultado, nombre_proyecto: proyecto, id_insertado: idProyecto, tipo} = JSON.parse( xhr.responseText );

            // comprovar la insercion 
            if ( resultado === 'correcto' ) {
                if ( tipo === 'crear' ) {
                    // Inyectar el html 
                    const nuevoProyecto = document.createElement('li');
                    nuevoProyecto.innerHTML = `
                        <a href="index.php?id_proyecto=${idProyecto}" id="proyecto:${idProyecto}">
                            ${nombreProyecto}
                        </a>
                    `;
                    listaProyectos.appendChild( nuevoProyecto );

                    // enviar alerta 
                    Swal.fire({
                        icon: 'success',
                        title: 'Proyecto Creado',
                        text: 'El proyecto: ' + proyecto + ' se creo correctamente',
                    }).then( result => {
                        if ( result.value) window.location.href = `index.php?id_proyecto=${idProyecto}`;
                    });
                } else {

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

/** 
 * * Agregar una nueva tarea al proyecto actual
 * 
*/
const agregarTarea = ( e ) => {
    e.preventDefault();

    const nombreTarea = document.querySelector('.nombre-tarea').value;
    const idProyecto = document.querySelector('#id-proyecto').value;

    if ( nombreTarea === '' ) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Una tarea no puede ir vacia!',
        });
    } else {
        // Crear llamado a ajax 
        const xhr = new XMLHttpRequest();

        const datos = new FormData();

        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', idProyecto);

        xhr.open('POST', 'inc/models/modelo-tareas.php', true );

        xhr.onload = function() {
            if ( this.status === 200 ) {
                const {respuesta: resultado, tarea, id_insertado:idInsertado, tipo } = JSON.parse(xhr.responseText );
                
                if ( resultado === 'correcto') {
                    if ( tipo === 'crear' ) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tarea Creado',
                            text: 'La tarea: < ' + tarea + ' > se creo correctamente',
                        });

                        // selecionar el parrafo con la lista vacia 
                        const parrafoListaVacia = document.querySelectorAll('.lista-vacia');
                        
                        if ( parrafoListaVacia.length > 0 ) document.querySelector('.lista-vacia').remove();

                        const nuevaTarea = document.createElement('li');
                        nuevaTarea.id = `tarea:${idInsertado}`;
                        nuevaTarea.classList.add('tarea');
                        nuevaTarea.innerHTML = `
                            <p>${tarea}</p>
                            <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        `;

                        const listado = document.querySelector('.listado-pendientes ul');
                        listado.appendChild( nuevaTarea );

                        document.querySelector('.agregar-tarea').reset();
                        // Actualizar el progrgeso 
                        actualizarProgreso();
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

/** 
 * * Cambia el estado de la tarea o las elimina
 * 
*/
const accionesTareas = ( e ) => {
    e.preventDefault();

    if ( e.target.classList.contains('fa-check-circle') ) {
        e.target.classList.toggle('completo');
        cambiarEstadoTarea( e.target );
    }
    if ( e.target.classList.contains('fa-trash') ) {
         
        Swal.fire({
            title: 'Seguro(a)?',
            text: "Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            const tareaEminar = e.target.parentElement.parentElement;
            // Borrar de la bd 
            eminarTareaBD( tareaEminar );
            // Borrar del DOM
            tareaEminar.remove();
            console.log( tareaEminar);
            if (result.isConfirmed) {
            Swal.fire(
                'Eliminado!',
                'La tarea fue eliminada.',
                'success'
            )
            }
        })
    }
}

const cambiarEstadoTarea = ( tarea ) => {
     const idTarea = tarea.parentElement.parentElement.id.split(':')[1];

     const estado = ( tarea.classList.contains('completo') ) ? 1 : 0;

     const xhr = new XMLHttpRequest();

     const datos =  new FormData();
     datos.append('id', idTarea);
     datos.append('accion', 'actualizar');
     datos.append('estado', estado)


     xhr.open('POST', 'inc/models/modelo-tareas.php', true );

     xhr.onload = function () {
        if ( this.status === 200 ) {
            console.log(xhr.responseText);
            actualizarProgreso();
        }
    }

    xhr.send(datos);
}


/** 
 * * Eliminar la tarea de la base de datos
 * 
*/
const eminarTareaBD = ( tarea ) => {
    const idTarea = tarea.id.split(':')[1];

    const estado = ( tarea.classList.contains('completo') ) ? 1 : 0;
    console.log(idTarea)
    console.log(estado)
    

    const xhr = new XMLHttpRequest();

    const datos =  new FormData();
    datos.append('id', idTarea);
    datos.append('accion', 'eliminar');
    datos.append('estado', estado)


    xhr.open('POST', 'inc/models/modelo-tareas.php', true );

    xhr.onload = function () {
    if ( this.status === 200 ) {
            console.log(xhr.responseText);

            const listaTareaRestante = document.querySelectorAll('li.tarea');
            if ( listaTareaRestante.length === 0 ) {
                document.querySelector('.listado-pendientes ul').innerHTML = `<p class="lista-vacia">No hay tareas</p>`;
            }
            // Actualizar progreso 
            actualizarProgreso();
        }
    }

    xhr.send(datos);
}

/** 
 * * Actualizar el progreso del proyecto
 * 
*/
const actualizarProgreso = () => {
    // obtener todas las tareas 
    const tareas = document.querySelectorAll('li.tarea');
    // obtener las tareas completaas    
    const tareasCompletadas = document.querySelectorAll('i.completo');
    // determinar avance 
    const avance = Math.round( ( tareasCompletadas.length / tareas.length ) * 100 );
    // asignar el avance a la barra 
    const porcentaje = document.querySelector('#porcentaje');
    porcentaje.style.width = avance + '%';

    // mostrar alerta al completar 100% 
    if ( avance === 100 ) {
        Swal.fire({
            icon: 'success',
            title: 'Proyecto Terminado',
            text: 'Ya no tiens tareas pendientes',
        });
    }
}




// * CARGAR EVENTOS
const eventListeners = () => {

    document.addEventListener('DOMContentLoaded', () => {
        actualizarProgreso();
    });

    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoPoryecto );

    // Boton para una nueva tarea 
    document.querySelector('.nueva-tarea').addEventListener('click', agregarTarea );

    // Botones para las acciones de las tareas 
    document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas );

}

eventListeners();
