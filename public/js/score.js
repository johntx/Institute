$(document).ready(function() {
    var table = $('.tabla_assistance_ver table').DataTable( {
        scrollY:        "420px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
		searching: false,
		ordering: false,
		info: false,
        fixedColumns:   {
            leftColumns: 1//Le indico que deje fijas solo las 2 primeras columnas
        }
    } );
});
$(document).ready(function() {
    var table = $('.tabla_score_ver table').DataTable( {
        scrollY:        "330px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
		searching: false,
		ordering: false,
		info: false,
        fixedColumns:   {
            leftColumns: 1//Le indico que deje fijas solo las 2 primeras columnas
        }
    } );
});