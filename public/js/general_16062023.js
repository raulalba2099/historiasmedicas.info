$(document).ready(function(){

    var tabla =  $('#tablaPacientes').DataTable(
        {
            "order": [],

            "columnDefs":
                [ {
                    "targets"  : 'no-ord',
                    "orderable": false,

                }],

            "searching": true
            ,"language": {
                "lengthMenu": "Mostrando _MENU_  registros por p&aacute;gina",
                "zeroRecords": "No existen registros.",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin registros",
                "infoFiltered": "",
                "search": "<i class='fas fa-search'></i>",
                "searchPlaceholder": "Buscar...",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                },
            }
        });

    var tablaNotas = $('#tablaNotas').DataTable(
        {
            "order": [],
            "columnDefs":
                [ {
                    "targets"  : 'no-ord',
                    "orderable": false,

                }],
            "searching": true
            ,"language": {
                "lengthMenu": "Mostrando _MENU_  registros por p&aacute;gina",
                "zeroRecords": "No existen registros.",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin registros",
                "infoFiltered": "",
                "search": "<i class='fas fa-search'></i>",
                "searchPlaceholder": "Buscar...",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                },
            }
        });

    var tablaReceta = $('#tablaReceta').DataTable(
        {
            "order": [],
            "columnDefs":
                [ {
                    "targets"  : 'no-ord',
                    "orderable": false,

                }],
            "searching": true
            ,"language": {
                "lengthMenu": "Mostrando _MENU_  registros por p&aacute;gina",
                "zeroRecords": "No existen registros.",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin registros",
                "infoFiltered": "",
                "search": "<i class='fas fa-search'></i>",
                "searchPlaceholder": "Buscar...",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                },
            }
        });

    var tablaEstudios = $('#tablaEstudios').DataTable(
        {
            "order": [],
            "columnDefs":
                [ {
                    "targets"  : 'no-ord',
                    "orderable": false,

                }],
            "searching": true
            ,"language": {
                "lengthMenu": "Mostrando _MENU_  registros por p&aacute;gina",
                "zeroRecords": "No existen registros.",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin registros",
                "infoFiltered": "",
                "search": "<i class='fas fa-search'></i>",
                "searchPlaceholder": "Buscar...",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                },
            }
        });

    $(document).on("click", ".eliminarRegistro", function(){
       let tabla = undefined;
        var fila = $(this);
        var action = $(this).attr("action");
        var method = $(this).attr("method");
        var ruta = $(this).attr("ruta");
        var token = $(this).children("[name='_token']").attr("value");

        // var token = $(this).attr("token");
        swal({
            title: '¿Está seguro de eliminar este registro?',
            text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar registro!'
        }).then(function(result){

            if(result.value){
                var datos = new FormData();
                datos.append("_method", method);
                datos.append("_token", token);

                $.ajax({
                    url: action,
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        // console.log(respuesta.mensaje);
                        if (respuesta == "existe-registro-paciente") {

                            swal({
                                type:"warning",
                                title: "¡Warning!",
                                text: "El paciente tiene registros por lo cual no podrá eliminarse.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            })
                        }
                        if(respuesta == "ok"){
                            swal({
                                type:"success",
                                title: "¡El registro ha sido eliminado!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){

                                    fila.parents('tr').remove().draw();

                                }
                            })
                        }
                        if(respuesta.mensaje == 'medicamento-eliminado') {
                            swal({
                                type:"success",
                                title: "¡El registro ha sido eliminado!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){

                                    window.location.href = './'+respuesta.datos[0]['rec_cit_id']; //Will take you to Google.
                                }
                            })
                        }
                        if (respuesta == 'existe-registro-subseccion') {
                            swal({
                                type:"warning",
                                title: "¡Warning!",
                                text: "La sección tiene Subsecciones asociadass por lo cual no podrá eliminarse.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            })
                        }
                        if (respuesta == 'existe-registro-preguntas') {
                            swal({
                                type:"warning",
                                title: "¡Warning!",
                                text: "La Subsección tiene preguntas asociadas por lo cual no podrá eliminarse.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            })
                        }
                        if (respuesta == 'existe-registro-respuestas') {
                            swal({
                                type:"warning",
                                title: "¡Warning!",
                                text: "La pregunta tiene respuestas asociadas por lo cual no podrá eliminarse.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            })
                        }
                    },
                    /*/error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                    }*/
                })
            }
        })

    });

    $(document).on('click','.deshabilitarRegistro', function () {

        let tabla = undefined;
        var boton = $(this);
        var action = $(this).attr("action");
        var method = $(this).attr("method");
        var ruta = $(this).attr("ruta");
        var token = $(this).children("[name='_token']").attr("value");
        var fila = $(this).attr('fila');

        console.log(method);

        // var token = $(this).attr("token");
        swal({
            title: 'El registro quedará deshabilitado',
            text: "¿Desea deshabilitar el registro?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Deshabilitar'
        }).then(function(result){

            if(result.value){
                var datos = new FormData();
                datos.append("_method", method);
                datos.append("_token", token);

                $.ajax({
                    url: action,
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        // console.log(respuesta.mensaje);
                        if(respuesta == "ok"){
                            swal({
                                type:"success",
                                title: "¡El registro se ha deshabilitado!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){

                                    $('#deshabilitar_'+fila).attr('disabled', 'true');
                                    $('#habilitar_'+fila).removeAttr('disabled');
                                    $('#editar_'+fila).attr('disabled', 'true');

                                    $('#estado_'+fila).text('');
                                    $('#estado_'+fila).text('Deshabilitado');
                                }
                            })
                        }
                    },
                })
            }
        })
    });

    $(document).on('click','.habilitarRegistro', function () {

        let tabla = undefined;

        var action = $(this).attr("action");
        var method = $(this).attr("method");
        var ruta = $(this).attr("ruta");
        var token = $(this).children("[name='_token']").attr("value");
        var fila = $(this).attr('fila');

        // var token = $(this).attr("token");
        swal({
            title: 'El registro quedará habilitado',
            text: "¿Desea habilitar el registro?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Habilitar'
        }).then(function(result){

            if(result.value){
                var datos = new FormData();
                datos.append("_method", method);
                datos.append("_token", token);

                $.ajax({
                    url: action,
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        // console.log(respuesta.mensaje);
                        if(respuesta == "ok"){
                            swal({
                                type:"success",
                                title: "¡El registro se ha habilitado!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){


                                    $('#habilitar_'+fila).attr('disabled', 'true');
                                    $('#deshabilitar_'+fila).removeAttr('disabled');
                                    $('#editar_'+fila).removeAttr('disabled');
                                    $('#estado_'+fila).text('');
                                    $('#estado_'+fila).text('Habilitado');
                                }
                            })
                        }
                    },
                })
            }
        })
    });
});

