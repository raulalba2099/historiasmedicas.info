$(document).ready(function () {

    let fila =  $(".fila").val() ;
    let url = $("#url").val();
    $(document).on('click','#btnNuevoReceta', function () {
        fila ++;
        $('.botones').remove();
        $(".caja").removeClass('d-none');
        $("#recetaForm").append(`
                <input  class="form-control input-nuevo col-sm-7  mt-2 ${fila}"
                type="text" name="medicamento_${fila}" value="" placeholder="Mddedicamento">
                <input  class="form-control input-nuevo col-sm-2 mt-2 ${fila}"
                type="text" name="dosis_${fila}" value="" placeholder="Dosis">
                <input  class="form-control input-nuevo  col-sm-2 mt-2 ${fila}"
                type="text" name="duracion_${fila}" value="" placeholder="Duración">

                <button fila="${fila}" class="btn btn-danger btn-sm quitarInput ml-2 mt-3 mt-md-0 text-white ${fila} mt-3 mt-md-0">
                   <i class="fas fa fa-minus"></i>
                </button>
                 <div class="col-sm-12 mt-4 float-right botones">
                    <button type="submit" name="guardarReceta" id="btnGuardarReceta" class="btn btn-primary float-right">
                        Guardar Receta
                    </button>
                    <button class="btn btn-light float-right" type="reset"> Cancelar</button>
                </div>
        `);

        $("#numero_inputs").val(fila);
        $("#fila").val(fila);

        $('.quitarInput').on('click', function() {
            let renglon = $(this).attr('fila');
            $('.'+renglon).remove();
             fila --;
        });

        $("#cancelar").on('click', function() {
            fila = 0;
            $(".input-nuevo").remove();
            $(".caja").addClass('d-none');
        });

    });

    $('#btnEnviarReceta').on('click', function () {

        $('#enviarReceta').modal('show');

        return false;
    });

});
