$(document).ready(function(){
    var tabla = $('#tablaCitas').DataTable(
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
});


