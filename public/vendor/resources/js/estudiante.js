var estudiantes, idlast, accion;
function filtrarEstudiantes() {
    // Obtener los valores de los filtros
    var seccion = $('#filtroSeccion').val();
    var bachillerato = $('#filtroBachillerato').val();

    // Recargar la tabla con los nuevos parámetros de filtro
    estudiantes.setGridParam({
        postData: {
            seccion: seccion,
            bachillerato: bachillerato
        }
    }).trigger('reloadGrid');
}
// Función para cargar los filtros dinámicos
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
$(function () {
    // Configuración del JqGrid
    $.jgrid.defaults.responsive = true;
    $.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-hover table-sm";

    estudiantes = $('#estudiantes').jqGrid({
        url: 'estudiantes/obtener_estudiantes',
        datatype: "json",
        styleUI: "Bootstrap5",
        iconSet: "fontAwesome",
        mtype: "POST",
        colModel: [
            { label: 'ID', name: 'id', index: 'id', width: 50 },
            { label: 'Nombre Completo', name: 'nombre_completo', index: 'nombre_completo', width: 250 },
            { label: 'Seccion', name: 'seccion', index: 'seccion', width: 100 },
            { label: 'Bachillerato', name: 'bachillerato', index: 'bachillerato', width: 150 },
            { label: 'NIE', name: 'nie', index: 'nie', width: 100, align: "center" },
            { label: 'Año', name: 'anio', index: 'anio', width: 100 }
        ],
        postData: {
            seccion: function () { return $('#filtroSeccion').val(); },
            bachillerato: function () { return $('#filtroBachillerato').val(); }
        },
        shrinkToFit: false,
        width: $('.container').width(),
        height: $(window).height() * 0.65,
        rowNum: 100,
        rownumbers: true,
        rowNumWidth: 35,
        pager: '#navestudiantes',
        sortname: 'nombre_completo',
        viewrecords: true,
        sortorder: "asc",
        loadComplete: function(data) {
            //console.log("Datos cargados:", data); // Ver datos que llegan
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
        estudiantes.setGridParam({
            postData: {
                seccion: seccion,
                bachillerato: bachillerato
            }
        }).trigger('reloadGrid');
    });
    $('#filtroSeccion').change(function() {
        $('#estudiantes').jqGrid('setGridParam', { // Actualiza parámetros del grid
            page: 1, // Regresa a la primera página
            postData: { // Actualiza los datos que se enviarán
                seccion: $(this).val(), // Valor actual del filtro
                bachillerato: $('#filtroBachillerato').val() // Mantiene el valor actual de bachillerato
            }
        }).trigger('reloadGrid'); // Recarga el grid
    });
    
    // Cuando se cambia el bachillerato
    $('#filtroBachillerato').change(function() {
        $('#estudiantes').jqGrid('setGridParam', {
            page: 1,
            postData: {
                seccion: $('#filtroSeccion').val(), // Mantiene el valor actual de sección
                bachillerato: $(this).val() // Valor actual del filtro
            }
        }).trigger('reloadGrid'); // Recarga el grid
    });
    estudiantes.navGrid('#navestudiantes', { edit: false, add: false, del: false, view: true, search: false });

    $('#formEstudiante').formValidation({
        framework: 'bootstrap4',
        excluded: '[readonly=readonly]',
        icon: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            numero_orden: {
                validators: {
                    notEmpty: {
                        message: 'Numero orden obligatorio'
                    }
                }
            },
            nombre_completo: {
                validators: {
                    notEmpty: {
                        message: 'Nombre Obligatorio'
                    }
                }
            },
            seccion: {
                validators: {
                    notEmpty: {
                        message: 'Seccion Obligatorio'
                    }
                }
            },
            bachillerato: {
                validators: {
                    notEmpty: {
                        message: 'Bachillerato Obligatorio'
                    }
                }
            },
            nie: {
                validators: {
                    notEmpty: {
                        message: 'NIE Obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,  // Expresión regular que solo acepta números
                        message: 'El NIE solo puede contener números'
                    }
                }
            },
            anio: {
                validators: {
                    notEmpty: {
                        message: 'Año Obligatoria'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,  // Expresión regular que solo acepta números
                        message: 'El NIE solo puede contener números'
                    }
                }
            }
        }
    })
        .on('success.field.fv', function (e, data) {
            //console.log(data);
            if (data.fv.getInvalidFields().length > 0) {
                data.fv.disableSubmitButtons(true);
            }
        })
        .on('success.form.fv', function (e) {
            e.preventDefault();
            //console.log(e);
            var $form = $(e.target),
                fv = $(e.target).data('formValidation');

            guardar();
        });
});

function agregar() {
    accion = 0;
    $('#formEstudiante').formValidation('resetForm', true);
    $('#formEstudiante')[0].reset();
    $('[name=numero_orden]').attr('readonly', false);
    $('#modalEstudiante').modal('show');
}

function guardar() {
    //console.log($('#formEstudiante').serialize());  // Verifica los datos serializados
    $.ajax({
        url: 'estudiantes/guardar',
        type: 'post',
        dataType: 'json',
        data: $('#formEstudiante').serialize() + '&accion=' + accion,
        success: function (response) {
            //console.log(response);
            $('#modalEstudiante').modal('hide');
            estudiantes.trigger('reloadGrid');
        },
        error: function (xhr, status, error) {
            // Agrega manejo de errores
            //console.error("Error al enviar el formulario:", error);
            // Esto mostrará la respuesta completa del servidor
            //console.log("Respuesta del servidor:", xhr.responseText);
        }
    });
}
function editar() {
    var selectedRow = $('#estudiantes').jqGrid('getGridParam', 'selrow');
    if (selectedRow) {
    var rowData = $('#estudiantes').jqGrid('getRowData', selectedRow);
        var idlast = rowData.id;
        //console.log("Selected row ID: ", rowData.id);
        $.ajax({
            url: 'estudiantes/editar',
            type: 'post',
            dataType: 'json',
            data: { id: idlast },
            success: function (data) {
                accion = 1;
                $('#formEstudiante').formValidation('resetForm', true);
                $('#formEstudiante')[0].reset();
                $('[name=numero_orden]').val(data.numero_orden).attr('readonly', true);
                $('[name=nombre_completo]').val(data.nombre_completo);
                $('[name=seccion]').val(data.seccion);
                $('[name=bachillerato]').val(data.bachillerato);
                $('[name=nie]').val(data.nie);
                $('[name=anio]').val(data.ano);
                $('#modalEstudiante').modal('show');
            }
        });
    } else {
        alertify.alert('Debe seleccionar el registro a editar.').set({ title: 'Error', label: 'Aceptar' });
    }
}

function eliminar() {
    var selectedRow = $('#estudiantes').jqGrid('getGridParam', 'selrow');
    if (selectedRow) {
    var rowData = $('#estudiantes').jqGrid('getRowData', selectedRow);
        var idlast = rowData.id;
        //console.log("Selected row ID: ", rowData.id);
        alertify.confirm("¿Está seguro de eliminar el registro del estudiante?",
            function () {
                $.ajax({
                    url: 'estudiantes/eliminar',
                    type: 'post',
                    dataType: 'json',
                    data: { id: idlast },
                    success: function (responce) {
                        estudiantes.trigger('reloadGrid');
                    }
                });
            },
            function () { }).set({ title: 'Confirmación', labels: { ok: 'SI', cancel: 'NO' } });
        }else{
            alertify.alert('Debe seleccionar un registro para eliminar.').set({ title: 'Error', label: 'Aceptar' });
        }
}
function informetabla() {
    const datos = {
        seccion: $('#filtroSeccion').val(),
        bachillerato: $('#filtroBachillerato').val()
    };
    //console.log("reporte",datos);
    // Construir la URL con los parámetros
    var url = 'estudiantes/informetabla';

    // Redirigir a la URL
    window.open(url, '_blank'); // Abre en una nueva pestaña
}
