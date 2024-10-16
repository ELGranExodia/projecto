$(document).ready(function() {
    // Inicializar Select2 en los campos
   /* $('#comida').select2({
        placeholder: "Selecciona una comida",
        allowClear: true
    });

    $('#estudiante').select2({
        placeholder: "Selecciona un estudiante",
        allowClear: true
    });
*/
    // Cargar las opciones dinámicamente
    cargarComidas();
    cargarEstudiantes();
});

// Función para cargar opciones de comidas desde el servidor
function cargarComidas() {

    $.ajax({
        url: 'registrocomida/obtener_listacomidas', // La ruta para obtener las comidas
        type: 'post',
        dataType: 'json',
        success: function(data) {
       //     console.log("Respuesta del servidor:", data); // Verifica qué está devolviendo el servidor
            let comidas = data;
            $('#comida').empty();
            comidas.forEach(function(comida) {
                $('#comida').append(new Option(comida.nombre_platillo, comida.id_comida));
            });
        }
    });
}

// Función para cargar opciones de estudiantes desde el servidor
function cargarEstudiantes() {
    $.ajax({
        url: 'estudiantes/obtener_listaestudiantes', // La ruta para obtener los estudiantes
        type: 'post',
        dataType: 'json',
        success: function(data) {
         //   console.log("Respuesta del servidor:", data);
            let estudiantes = data;
            $('#estudiante').empty(); // Limpiar el select
            estudiantes.forEach(function(estudiante) {
                $('#estudiante').append(new Option(estudiante.nombre_completo, estudiante.numero_orden));
            });
        }
    });
}
