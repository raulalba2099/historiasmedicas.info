$(document).ready(function(){
    $('#buscaPaciente').on('keyup',   function() {
        let paciente =  $(this).val();
        var method = 'GET';
        var action = $(this).attr("action")+'/'+paciente;
        var token = $(this).next("[name='_token']").attr("value");
        let datos = {"_method": method, "token" : token }
       $.ajax({
           url: action,
           method: "GET",
           data: datos,
           cache: false,
           contentType: false,
           processData: false,
           success:function(data){
             if(data) {
                 if(data.status == 400) {
                     $('.error').removeClass('d-none');
                 } else {
                     $('.error').addClass('d-none');
                 }
                 let materno = '';
                 if(data.pacientes.pac_materno != null) {
                     materno = data.pacientes.pac_materno;
                 }
                 let nombreCompleto = data.pacientes.pac_nombre + ' ' + data.pacientes.pac_paterno + ' ' + materno;
                 let html = '';
                 $.each( data.pacientes, function( key, paciente ) {
                     html = html + `
                       <option value="${paciente.pac_id}"> ${paciente.pac_nombre +  ' ' + paciente.pac_paterno + ' ' + paciente.pac_materno } </option>
                      `
                 });
                 $('#id').html('');
                 $('#id').append(html);
             }
           }

       });
    });

    $('.cancelar').on('click',function(e) {

        $('#buscaPaciente').val('');
        $('.error').addClass('d-none');
        $('#crearCita').modal('hide');

        return false;
    })
});
