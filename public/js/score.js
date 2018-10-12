$(document).ready(function() {
    var hh = window.innerHeight-220;
    var hh2 = window.innerHeight-300;
    var table = $('.tabla_assistance_ver table').DataTable( {
        scrollY:        hh+"px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
		searching: false,
		ordering: false,
		info: false,
        fixedColumns:   {
            leftColumns: 1//Le indico que deje fijas solo las 2 primeras columnas
        }
    });
    var table = $('.tabla_score_ver table').DataTable( {
        scrollY:        hh2+"px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
		searching: false,
		ordering: false,
		info: false,
        fixedColumns:   {
            leftColumns: 1//Le indico que deje fijas solo las 2 primeras columnas
        }
    });
});