$(document).ready(function () {

    let modulo =   $('#moduloMenu').val();

    if (modulo == null) {
        // $("html, body").animate({
        //     scrollTop: 350}, 10, 'swing');
    } else {
        $("html, body").animate({
            scrollTop: 350}, 10, 'swing');
    }

    $('#btnNuevoMenu').on('click', function (e) {

        $('#comida').val('0');
        $('#dia').val('0');
        $('#descripcionMenu').val();
        $('.tox-tinymce').addClass('border-primary');
        $('#agregaMenu').modal('show');

        return false;
    });

    $('.editar-comida').on('click', function () {

        $('.tox-tinymce').addClass('border-primary');

        let men_id = $(this).attr('men_id');
        let com_id = $(this).attr('com_id');
        let dia = $(this).attr('dia');
        let descripcion = $(this).next().text();

        if(com_id == 1 || com_id == 3) {
            $('#div-dia').addClass('d-none');
        }else {
            $('#div-dia').removeClass('d-none');
        }

        $('#men_id').val(men_id);

        $("#dia option[value="+ dia +"]").attr("selected",true);
        $("#comida option[value="+ com_id +"]").attr("selected",true);
        // tinymce.get("myTextarea").setContent("<p>Hello world!</p>");
        // $("textarea#descripcionMenu").setContent(descripcion);
        // $('#tinymce').append(descripcion);
        tinymce.get("descripcionMenu").setContent(descripcion);
        $('#agregaMenu').modal('show');
    });

    $('#cancelar-menu').on('click', function (event) {

        // $('#descripcion-menu').val('');
        // $('#agregaMenuForm')[0].reset();
        $('#agregaMenu').modal('hide');

        return false;
    });


    tinymce.init({
        selector: '#descripcionMenu',
        promotion: false,
        statusbar: false

    });

    tinymce.init({
        selector: '#recomendaciones',
        promotion: false,
        statusbar: false
    });

    $('#comida').on('click', function () {
        let comida =$(this).val();
        if(comida == 1 || comida ==3) {
            $('#div-dia').addClass('d-none');
        }else {
            $('#div-dia').removeClass('d-none');
        }
    });

    $('#btnGuardarMenu').on('click', function (event) {
         // let token = $(this).children("[name='_token']").attr("value");

        tinyMCE.triggerSave();
        tinymce.activeEditor.setProgressState(true)
        tinymce.activeEditor.setProgressState(false, 300)

         let men_id = $('#men_id').val();
         let com_id =  $('#comida').val();
         let dia = $('#dia').val();
         let descripcion = $('#descripcionMenu').val();
         let pac_id = $('#pac_id').val();
         let cit_id = $('#citId').val();
         let fecha = $('#fechaMenu').val();
         let url = '../menu';
         let method = "POST";

         var datos = new FormData();

        // datos.append("_token","{{ csrf_token() }}");
        datos.append("_method", method);
        datos.append("men_id", men_id);
        datos.append("com_id", com_id);
        datos.append("dia", dia);
        datos.append("descripcion", descripcion);
        datos.append("pac_id", pac_id);
        datos.append("cit_id", cit_id);
        datos.append("fecha", fecha);

             $.ajax({
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     url: url,
                     method: "POST",
                     data: datos,
                     cache: false,
                     contentType: false,
                     processData: false,
                     dataType: 'json',
                 success:function(respuesta){
                     if(respuesta.mensaje == 'ok'){

                         $('#agregaMenu').modal('hide');
                         swal({
                             type:"success",
                             title: "¡El registro se ha actualizado!",
                             showConfirmButton: true,
                             confirmButtonText: "Cerrar"
                         }).then(function(result){
                            window.location = './'+respuesta.cit_id;
                         })
                     }else if(respuesta == 'dia-requerido') {
                         swal({
                             type:"error",
                             title: "¡El día es requerido!",
                             showConfirmButton: true,
                             confirmButtonText: "Cerrar"
                         })
                     }else if(respuesta == 'comida-reuerido') {
                         swal({
                             type:"error",
                             title: "¡El tipo de comida es requerida!",
                             showConfirmButton: true,
                             confirmButtonText: "Cerrar"
                         })
                     }else if(respuesta == 'menu-existe') {
                         swal({
                             type:"error",
                             title: "¡Ya existe un Menu para la comida y el día seleccionado!",
                             showConfirmButton: true,
                             confirmButtonText: "Cerrar"
                         })
                     }
                 },
             })

        return false;
    });

    /*Recomendaciones Menu*/
    $('#btnGuardarRecomendaciones').on('click', function () {

        tinyMCE.triggerSave();
        tinymce.activeEditor.setProgressState(true);
        tinymce.activeEditor.setProgressState(false, 300);

        let rec_id = $('#recomendacionesId').val();
        let descripcion = $('#recomendaciones').val();
        let pac_id = $('#pac_id').val();
        let fecha = $('#fechaMenu').val();
        let cit_id = $('#citId').val();
        let url = '../recomendaciones-menu';
        let method = "POST";

        var datos = new FormData();

        // datos.append("_token","{{ csrf_token() }}");
        datos.append("_method", method);
        datos.append('rec_id', rec_id);
        datos.append("descripcion", descripcion);
        datos.append("pac_id", pac_id);
        datos.append("cit_id", cit_id);
        datos.append("fecha", fecha);

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: url,
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success:function(respuesta){
                if(respuesta.mensaje == 'ok'){
                    swal({
                        type:"success",
                        title: "¡El registro se ha actualizado!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        window.location = './'+respuesta.cit_id;
                    })
                }
            },
        })
    });

});
