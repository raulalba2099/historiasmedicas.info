
$(document).ready(function(){
       $('#tablaPacientes').DataTable(
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
                   "search": "<img src='./vistas/imgs/buscar2.jpg' width='30px'  title='Buscar'>",
                   "searchPlaceholder": "Buscar...",
                   "paginate": {
                   "previous": "Anterior",
                   "next": "Siguiente"
                     },
              }
       });
});
