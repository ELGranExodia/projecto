var proveedores, idlast, accion;
$(function () {
    // Configuración del JqGrid
    // Configuramos la tabla dinámica para que sea responsive
    $.jgrid.defaults.responsive = true;

    // Aplicamos las clases de Bootstrap en la tabla dinámica
    $.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-hover table-sm";

    proveedores = $('#proveedores').jqGrid({
        url: 'proveedores/obtener_proveedores',
        datatype: "json",
        styleUI: "Bootstrap5",
        iconSet: "fontAwesome",
        mtype: "POST",
        colModel: [ // Establece la estructura de la tabla dinamica
            { label: 'NIE', name: 'nie', index: 'nie', width: 100 },
            { label: 'NOMBRE COMPLETO', name: 'nombre_completo', index: 'nombre_completo', width: 300 },
            { label: 'SECCION', name: 'seccion', index: 'seccion', width: 250 },
            { label: 'BACHILLERATO', name: 'bachillerato', index: 'bachillerato', width: 250 },
        ],
        shrinkToFit: false,
        width: $('.container').width(),
        height: $(window).height() * 0.65,
        rowNum: 100, // Establece el número de filas o registros que se veran en la tabla
        rownumbers: true,
        rowNumWidth: 35,
        pager: '#navproveedores', // Indica el div de la barra de navegacion
        sortname: 'nombre_completo', // Indica el nombre del campo por el que se ordenan los registros
        viewrecords: true,
        sortorder: "asc", // Indica el ordenamiento ascendente o descendente
        onSelectRow: function (rowid, status, e) {
            idlast = rowid;
        }
    });

    // Configuramos la barra de navegación del JqGrid
    proveedores.navGrid('#navproveedores', { edit: false, add: false, del: false, view: true, search: false });

    // Validación del formulario
    $('#formEstudiante').formValidation({
        framework: 'bootstrap4',
        excluded: '[readonly=readonly]',
        icon: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            nrc: {
                row: '.col-md-3',
                validators: {
                    notEmpty: {
                        message: 'NIE Obligatorio'
                    },
                    remote: {
                        url: 'proveedores/verificarNrc',
                        type: 'post',
                        message: 'NIE ya existe'
                    }
                }
            },
            nombre_empresa: {
                validators: {
                    notEmpty: {
                        message: 'Obligatorio'
                    }
                }
            },
            razon_social: {
                validators: {
                    notEmpty: {
                        message: 'Obligatorio'
                    }
                }
            },
            persona_contacto: {
                validators: {
                    notEmpty: {
                        message: 'Obligatorio'
                    }
                }
            },
            telefono_contacto: {
                validators: {
                    notEmpty: {
                        message: 'Obligatorio'
                    }
                }
            },
            direccion: {
                validators: {
                    notEmpty: {
                        message: 'Obligatorio'
                    }
                }
            },
            correo_electronico: {
                validators: {
                    notEmpty: {
                        message: 'Obligatorio'
                    },
                    emailAddress: {
                        message: 'Correo electrónico incorrecto'
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

        guardar();
    });

});

function agregar() {
    // Si el valor de acción es igual a cero, significa que vamos a crear un nuevo
    // registro
    accion = 0;
    $('#formProveedor').formValidation('resetForm',true);
    $('#formProveedor')[0].reset();
    $('[name=nrc]').attr('readonly',false);
    $('#modalProveedor').modal('show');
}

// Método para guardar la información del formulario en la tabla proveedores
function guardar() {
    $.ajax({
        url: 'proveedores/guardar',
        type: 'post',
        dataType: 'json',
        data: $('#formProveedor').serialize() + '&accion=' + accion,
        success: function (responce) {
            $('#modalProveedor').modal('hide');
            proveedores.trigger('reloadGrid');
        }
    });
}

// Método para editar el registro seleccionado de la tabla dinámica
function editar() {
    if (idlast) {
        $.ajax({
            url: 'proveedores/editar',
            type: 'post',
            dataType: 'json',
            data: { id: idlast },
            success: function (data) {
                // Si el valor de acción es igual a uno, significa que vamos a
                // modificar el registro
                accion = 1;
                $('#formProveedor').formValidation('resetForm',true);
                $('#formProveedor')[0].reset();
                $('[name=nrc]').val(data.nrc).attr('readonly',true);
                $('[name=nombre_empresa]').val(data.nombre_empresa);
                $('[name=razon_social]').val(data.razon_social);
                $('[name=persona_contacto]').val(data.persona_contacto);
                $('[name=telefono_contacto]').val(data.telefono_contacto);
                $('[name=direccion]').val(data.direccion);
                $('[name=correo_electronico]').val(data.correo_electronico);
                $('#modalProveedor').modal('show');
            }
        });
    } else
        alertify.alert('Debe seleccionar el registro a editar.').set({ title: 'Error', label: 'Aceptar' });
}

// Método para eliminar registros de la tabla
function eliminar() {
    if (idlast) {
        alertify.confirm("¿Esta seguro de eliminar el registro del proveedor?",
            function () {
                $.ajax({
                    url: 'proveedores/eliminar',
                    type: 'post',
                    dataType: 'json',
                    data: { id: idlast },
                    success: function (responce) {
                        proveedores.trigger('reloadGrid');
                    }
                });
            },
            function () { }).set({ title: 'Confirmación', labels: { ok: 'SI', cancel: 'NO' } });
    } else
        alertify.alert('Debe seleccionar el registro a eliminar.').set({ title: 'Error', label: 'Aceptar' });
}