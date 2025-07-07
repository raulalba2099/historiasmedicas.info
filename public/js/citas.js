$(document).ready(function () {


    $(document).on("click", ".event", function () {
        let id = $(this).find('.id').val();
        window.location.href = './consulta/' + id;
    });

});
