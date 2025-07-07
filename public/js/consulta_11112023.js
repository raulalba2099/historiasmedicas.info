$(document).ready(function(){

    // $("html, body").animate({
    //     scrollTop: 1300}, 10, 'swing');

    $('.presion_arterial').on('blur', function() {
        let sistolica = $('#sistolica').val();
        let diastolica = $('#diastolica').val();
        let pam =  (diastolica * 2 + parseInt(sistolica)) / 3 ;
        $('#arterial').val($.number(pam, 1 ));
    });

    $('.calcula_imc').on('blur', function () {

        let peso = $('#peso').val();
        let talla = $('#talla').val();

        // let pesoTalla =(peso / talla);
        let tallaCuadrado = talla * talla;
        let imc = peso / tallaCuadrado;

        $('#imc').val($.number(imc,1));
    });
});
