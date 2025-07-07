$(document).ready(function () {

    tinymce.init({
        selector: '#areaMembrete',
        promotion: false,
        statusbar: false

    });
    $('.tox-tinymce').addClass('border-primary');
    // $('#btnGuardarMenu').on('click', function (event) {
    //      // let token = $(this).children("[name='_token']").attr("value");
    //
    //     tinyMCE.triggerSave();
    //     tinymce.activeEditor.setProgressState(true)
    //     tinymce.activeEditor.setProgressState(false, 300);
    //
    //      let men_id = $('#men_id').val();
    //      let com_id =  $('#comida').val();
    //      let dia = $('#dia').val();
    //      let descripcion = $('#descripcionMenu').val();
    //      let pac_id = $('#pac_id').val();
    //      let cit_id = $('#citId').val();
    //      let fecha = $('#fechaMenu').val();
    //      let url = '../menu';
    //      let method = "POST";
    //
    //      var datos = new FormData();
    //
    //     // datos.append("_token","{{ csrf_token() }}");
    //     datos.append("_method", method);
    //     datos.append("men_id", men_id);
    //     datos.append("com_id", com_id);
    //     datos.append("dia", dia);
    //     datos.append("descripcion", descripcion);
    //     datos.append("pac_id", pac_id);
    //     datos.append("cit_id", cit_id);
    //     datos.append("fecha", fecha);
    //
    //          $.ajax({
    //              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //                  url: url,
    //                  method: "POST",
    //                  data: datos,
    //                  cache: false,
    //                  contentType: false,
    //                  processData: false,
    //                  dataType: 'json',
    //              success:function(respuesta){
    //                  if(respuesta.mensaje == 'ok'){
    //
    //                      $('#agregaMenu').modal('hide');
    //                      swal({
    //                          type:"success",
    //                          title: "¡El registro se ha actualizado!",
    //                          showConfirmButton: true,
    //                          confirmButtonText: "Cerrar"
    //                      }).then(function(result){
    //                         window.location = './'+respuesta.cit_id;
    //                      })
    //                  }else if(respuesta == 'dia-requerido') {
    //                      swal({
    //                          type:"error",
    //                          title: "¡El día es requerido!",
    //                          showConfirmButton: true,
    //                          confirmButtonText: "Cerrar"
    //                      })
    //                  }else if(respuesta == 'comida-reuerido') {
    //                      swal({
    //                          type:"error",
    //                          title: "¡El tipo de comida es requerida!",
    //                          showConfirmButton: true,
    //                          confirmButtonText: "Cerrar"
    //                      })
    //                  }else if(respuesta == 'menu-existe') {
    //                      swal({
    //                          type:"error",
    //                          title: "¡Ya existe un Menu para la comida y el día seleccionado!",
    //                          showConfirmButton: true,
    //                          confirmButtonText: "Cerrar"
    //                      })
    //                  }
    //              },
    //          })
    //
    //     return false;
    // });

    /*Recomendaciones Menu*/

});
