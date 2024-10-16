var registroComida, idlast, accion;
// Función para filtrar por fechas
$('#fecha_fin').change(function () {
    var fechaInicio = $('#fecha_inicio').val();
    var fechaFin = $('#fecha_fin').val();

    if (fechaInicio && fechaFin) {
        // Configura los parámetros del grid
        $("#registroComida").jqGrid('setGridParam', {
            url: 'registrocomida/obtener_registro', // URL para obtener datos
            datatype: 'json',
            mtype: 'POST',
            postData: { // Pasar las fechas como datos POST
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            },
            page: 1 // Reinicia la página a 1 para mostrar los nuevos resultados
        }).trigger("reloadGrid"); // Recargar el grid
    } else {
        $("#registroComida").jqGrid('setGridParam', {
            url: 'registrocomida/obtener_registro', // URL para obtener datos
            datatype: 'json',
            mtype: 'POST',
            postData: { // Pasar las fechas como datos POST
                fecha_inicio: "",
                fecha_fin: ""
            },
            page: 1 // Reinicia la página a 1 para mostrar los nuevos resultados
        }).trigger("reloadGrid"); // Recargar el grid
    }
});

$(function () {
    // Configuración del JqGrid
    $.jgrid.defaults.responsive = true;
    $.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-hover table-sm";

    registroComida = $('#registroComida').jqGrid({
        url: 'registrocomida/obtener_registro', // URL para obtener datos
        datatype: "json",
        styleUI: "Bootstrap5",
        iconSet: "fontAwesome",
        mtype: "POST",
        colModel: [
            { label: 'ID', name: 'id_comida', index: 'id_comida', width: 50 },
            { label: 'Fecha Preparación', name: 'fecha_preparacion', index: 'fecha_preparacion', width: 150 },
            { label: 'Nombre Platillo', name: 'nombre_platillo', index: 'nombre_platillo', width: 250 },
            { label: 'Tipo Comida', name: 'tipo_comida', index: 'tipo_comida', width: 150 },
            { label: 'Ingredientes', name: 'ingredientes', index: 'ingredientes', width: 300 },
            { label: 'Porciones Preparadas', name: 'porciones_preparadas', index: 'porciones_preparadas', width: 150 },
            { label: 'Responsable', name: 'responsable', index: 'responsable', width: 150 }
        ],
        shrinkToFit: false,
        width: $('.container').width(),
        height: $(window).height() * 0.65,
        rowNum: 100,
        rownumbers: true,
        rowNumWidth: 35,
        pager: '#navRegistroComida',
        sortname: 'fecha_preparacion',
        viewrecords: true,
        sortorder: "asc",
        onSelectRow: function (rowid, status, e) {
            idlast = rowid;
        },
        loadComplete: function (data) {
            //console.log('Datos cargados en el grid:', data);
        }
    });

    registroComida.navGrid('#navRegistroComida', { edit: false, add: false, del: false, view: true, search: false });

    $('#formComida').formValidation({
        framework: 'bootstrap4',
        excluded: '[readonly=readonly]',
        icon: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            fecha_preparacion: {
                validators: {
                    notEmpty: {
                        message: 'Fecha de preparación obligatoria'
                    }
                }
            },
            nombre_platillo: {
                validators: {
                    notEmpty: {
                        message: 'Nombre del platillo obligatorio'
                    }
                }
            },
            tipo_comida: {
                validators: {
                    notEmpty: {
                        message: 'Tipo de comida obligatorio'
                    }
                }
            },
            ingredientes: {
                validators: {
                    notEmpty: {
                        message: 'Ingredientes obligatorios'
                    }
                }
            },
            porciones_preparadas: {
                validators: {
                    notEmpty: {
                        message: 'Porciones preparadas obligatorias'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,  // Expresión regular que solo acepta números
                        message: 'Las porciones solo pueden contener números'
                    }
                }
            },
            responsable: {
                validators: {
                    notEmpty: {
                        message: 'Responsable obligatorio'
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
            var $form = $(e.target),
                fv = $(e.target).data('formValidation');

            guardar();
        });
});

function agregar() {
    accion = 0;
    $('#formComida').formValidation('resetForm', true);
    $('#formComida')[0].reset();
    $('#modalComida').modal('show');
}

function guardar() {
    //console.log($('#formComida').serialize());  // Verifica los datos serializados
    $.ajax({
        url: 'registrocomida/guardar',
        type: 'post',
        dataType: 'json',
        data: $('#formComida').serialize() + '&accion=' + accion,
        success: function (response) {
            //console.log(response);
            $('#modalComida').modal('hide');
            registroComida.trigger('reloadGrid');
        },
        error: function (xhr, status, error) {
            // Agrega manejo de errores
            //console.error("Error al enviar el formulario:", error);
            //console.log("Respuesta del servidor:", xhr.responseText);
        }
    });
}

function editar() {
    if (idlast) {
        $.ajax({
            url: 'registrocomida/editar',
            type: 'post',
            dataType: 'json',
            data: { id_comida: idlast },
            success: function (data) {
                //console.log(data);
                accion = 1;
                $('#formComida').formValidation('resetForm', true);
                $('#formComida')[0].reset();
                $('[name=id_comida]').val(data.id_comida);
                $('[name=fecha_preparacion]').val(data.fecha_preparacion);
                $('[name=nombre_platillo]').val(data.nombre_platillo);
                $('[name=tipo_comida]').val(data.tipo_comida);
                $('[name=ingredientes]').val(data.ingredientes);
                $('[name=porciones_preparadas]').val(data.porciones_preparadas);
                $('[name=responsable]').val(data.responsable);
                $('#modalComida').modal('show');
            }
        });
    } else {
        alertify.alert('Debe seleccionar el registro a editar.').set({ title: 'Error', label: 'Aceptar' });
    }
}

function eliminar() {
    if (idlast) {
        alertify.confirm("¿Está seguro de eliminar el registro de comida?",
            function () {
                $.ajax({
                    url: 'registrocomida/eliminar',
                    type: 'post',
                    dataType: 'json',
                    data: { id_comida: idlast },
                    success: function (response) {
                        registroComida.trigger('reloadGrid');
                    }
                });
            },
            function () { }).set({ title: 'Confirmación', labels: { ok: 'SI', cancel: 'NO' } });
    } else {
        alertify.alert('Debe seleccionar el registro a eliminar.').set({ title: 'Error', label: 'Aceptar' });
    }
}
