var entregaComida, idlastEntrega, accionEntrega;
function cargarFiltros() {
    $.ajax({
        url: 'estudiantes/obtenerFiltros',
        type: 'POST',
        dataType: 'json',
        success: function (response) {

            var secciones = response.secciones;
            var bachilleratos = response.bachilleratos;

            // Llenar el select de secciones
            $.each(secciones, function (index, seccion) {
                $('#filtroSeccion').append('<option value="' + seccion.seccion + '">' + seccion.seccion + '</option>');
            });

            // Llenar el select de bachilleratos
            $.each(bachilleratos, function (index, bachillerato) {
                $('#filtroBachillerato').append('<option value="' + bachillerato.bachillerato + '">' + bachillerato.bachillerato + '</option>');
            });
        },
        error: function (xhr, status, error) {
            //console.error("Error en la solicitud:", error); // Mostrar errores en la consola
        }
    });
}
function filtrarEstudiantes() {
    // Obtener los valores de los filtros
    var seccion = $('#filtroSeccion').val();
    var bachillerato = $('#filtroBachillerato').val();

    // Recargar la tabla con los nuevos parámetros de filtro
    entregaComida.setGridParam({
        postData: {
            seccion: seccion,
            bachillerato: bachillerato,
            fecha: ''
        }
    }).trigger('reloadGrid');
}
$(function () {
    // Configuración del JqGrid para la entrega de comida
    $.jgrid.defaults.responsive = true;
    $.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-hover table-sm";

    // Configuración del JqGrid
    entregaComida = $('#entregaComida').jqGrid({
        url: 'entregacomida/obtener_registro',
        datatype: "json",
        styleUI: "Bootstrap5",
        mtype: "POST",
        postData: { fecha: '', 
                seccion: function () { return $('#filtroSeccion').val(); },
                bachillerato: function () { return $('#filtroBachillerato').val(); }
         }, // Inicialmente sin filtro
        colModel: [
            { label: 'ID', name: 'id_entrega', index: 'id_entrega', width: 50 },
            { label: 'Nombre completo', name: 'nombre_completo', index: 'nombre_completo', width: 250 },
            { label: 'Seccion', name: 'seccion', index: 'seccion', width: 100 },
            { label: 'Bachillerato', name: 'bachillerato', index: 'bachillerato', width: 150 },
            { label: 'NIE', name: 'nie', index: 'nie', width: 100 },
            { label: 'Año', name: 'anio', index: 'anio', width: 70 },
            { label: 'Fecha', name: 'fecha', index: 'fecha', width: 150 }
        ],
        pager: '#navEntregaComida',
        rowNum: 10,
        rowList: [10, 20, 30],
        sortname: 'id_entrega',
        viewrecords: true,
        sortorder: "asc",
        autowidth: true,
        height: $(window).height() * 0.65,
        rownumbers: true,
        rowNumWidth: 35,
        pagerpos: 'center',
        jsonReader: {
            repeatitems: false,
            id: "0"
        },
        loadComplete: function (data) {
            //console.log('Datos cargados:', data);
        }
    });
   // Cargar los filtros dinámicos al iniciar la página
   cargarFiltros();

   // Evento para filtrar por Sección y Bachillerato
   $('#filtroSeccion, #filtroBachillerato').change(function () {
       var seccion = $('#filtroSeccion').val();
       var bachillerato = $('#filtroBachillerato').val();
       // Log para ver los valores de los selectores en la consola del navegador
       //console.log("Sección seleccionada: ", seccion);
       //console.log("Bachillerato seleccionado: ", bachillerato);
       entregaComida.setGridParam({
           postData: {
               seccion: seccion,
               bachillerato: bachillerato,
               fecha: ''
           }
       }).trigger('reloadGrid');
   });
   $('#filtroSeccion').change(function() {
       $('#entregaComida').jqGrid('setGridParam', { // Actualiza parámetros del grid
           page: 1, // Regresa a la primera página
           postData: { // Actualiza los datos que se enviarán
               seccion: $(this).val(), // Valor actual del filtro
               bachillerato: $('#filtroBachillerato').val(),
               fecha: '' // Mantiene el valor actual de bachillerato
           }
       }).trigger('reloadGrid'); // Recarga el grid
   });
   
   // Cuando se cambia el bachillerato
   $('#filtroBachillerato').change(function() {
       $('#entregaComida').jqGrid('setGridParam', {
           page: 1,
           postData: {
               seccion: $('#filtroSeccion').val(), // Mantiene el valor actual de sección
               bachillerato: $(this).val(),
               fecha: '' // Valor actual del filtro
           }
       }).trigger('reloadGrid'); // Recarga el grid
   });
    // Evento del botón para filtrar por fecha
    $('#filtroFecha').change(function () {
        var fecha = $('#filtroFecha').val();
        //console.log(fecha);
        if (fecha) {
            //console.log("ok");
            entregaComida.jqGrid('setGridParam', {
                postData: { fecha: fecha, seccion: '', bachillerato: '' },
                page: 1
            }).trigger('reloadGrid');
        } else {
            // Si no se selecciona una fecha, recarga todos los datos
            entregaComida.jqGrid('setGridParam', {
                postData: { fecha: '', seccion: '', bachillerato: '' },
                page: 1
            }).trigger('reloadGrid');
        }
    });


    entregaComida.navGrid('#navEntregaComida', { edit: false, add: false, del: false, view: true, search: false });

    $('#formEntregaComida').formValidation({
        framework: 'bootstrap4',
        excluded: '[readonly=readonly]',
        icon: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            estudiante: {
                validators: {
                    notEmpty: {
                        message: 'El nombre del estudiante es obligatorio'
                    }
                }
            },
            comida: {
                validators: {
                    notEmpty: {
                        message: 'El platillo es obligatorio'
                    }
                }
            }
        }
    })
        .on('success.field.fv', function (e, data) {
            if (data.fv.getInvalidFields().length > 0) {
                data.fv.disableSubmitButtons(true);
            }
        })
        .on('success.form.fv', function (e) {
            e.preventDefault();
            var $form = $(e.target),
                fv = $(e.target).data('formValidation');

            guardarEntrega();
        });
});

function agregarEntrega() {
    accionEntrega = 0;
    $('#formEntregaComida').formValidation('resetForm', true);
    $('#formEntregaComida')[0].reset();
    $('#modalEntregaComida').modal('show');
}

function guardarEntrega() {
    $.ajax({
        url: 'entregacomida/guardar',  // Cambiar URL según tu API o servidor
        type: 'post',
        dataType: 'json',
        data: $('#formEntregaComida').serialize() + '&accion=' + accionEntrega,
        success: function (response) {
            $('#modalEntregaComida').modal('hide');
            entregaComida.trigger('reloadGrid');
        },
        error: function (xhr, status, error) {
            //console.error("Error al guardar la entrega:", error);
            //console.log("Respuesta del servidor:", xhr.responseText);
        }
    });
}

function editarEntrega() {
    if (idlastEntrega) {
        $.ajax({
            url: 'entregacomida/editar',  // Cambiar URL según tu API o servidor
            type: 'post',
            dataType: 'json',
            data: { id_entrega: idlastEntrega },
            success: function (data) {
                accionEntrega = 1;
                $('#formEntregaComida').formValidation('resetForm', true);
                $('#formEntregaComida')[0].reset();
                $('[name=id_entrega]').val(data.id_entrega);
                $('[name=fecha_entrega]').val(data.fecha_entrega);
                $('[name=nombre_estudiante]').val(data.nombre_estudiante);
                $('[name=nombre_platillo]').val(data.nombre_platillo);
                $('[name=cantidad]').val(data.cantidad);
                $('[name=responsable]').val(data.responsable);
                $('#modalEntregaComida').modal('show');
            }
        });
    } else {
        alertify.alert('Debe seleccionar un registro para editar.').set({ title: 'Error', label: 'Aceptar' });
    }
}

function eliminarEntrega() {
    var selectedRow = $('#entregaComida').jqGrid('getGridParam', 'selrow');
    if (selectedRow) {
        var rowData = $('#entregaComida').jqGrid('getRowData', selectedRow);
        var id_entrega = rowData.id_entrega;
        //console.log("Selected row ID: ", id_entrega);
        // Rest of your code here
        alertify.confirm("¿Está seguro de eliminar la entrega?",
            function () {
                $.ajax({
                    url: 'entregacomida/eliminar',  // Cambiar URL según tu API o servidor
                    type: 'post',
                    dataType: 'json',
                    data: { id_entrega: id_entrega },
                    success: function (response) {
                        //console.log(response);
                        id_entrega = 0;
                        entregaComida.trigger('reloadGrid');

                    }
                });
            },
            function () { }).set({ title: 'Confirmación', labels: { ok: 'SI', cancel: 'NO' } });
    } else {
        alertify.alert('Debe seleccionar un registro para eliminar.').set({ title: 'Error', label: 'Aceptar' });
    }
}
